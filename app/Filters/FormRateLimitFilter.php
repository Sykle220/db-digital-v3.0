<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Throttle\Throttler;

class FormRateLimitFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! $request->is('post')) {
            return null;
        }

        $settings = service('siteSettings');
        $max      = max(1, (int) $settings->get('form_rate_limit_max', '8'));
        $minutes  = max(1, (int) $settings->get('form_rate_limit_minutes', '15'));
        $seconds  = $minutes * 60;

        $ip  = $request->getIPAddress();
        $key = 'form_' . md5($ip . '|' . $request->getUri()->getPath());

        /** @var Throttler $throttler */
        $throttler = service('throttler');

        if ($throttler->check($key, $max, $seconds) === false) {
            if ($request->isAJAX() || str_contains((string) $request->getHeaderLine('Accept'), 'application/json')) {
                return service('response')
                    ->setStatusCode(429)
                    ->setJSON(['success' => false, 'message' => 'Trop de tentatives. Réessayez plus tard.']);
            }

            return redirect()->back()
                ->with('error', 'Trop de tentatives. Veuillez patienter avant de réessayer.');
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}
