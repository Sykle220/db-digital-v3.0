<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class LocaleFilter implements FilterInterface
{
    /** @var list<string> */
    private const LOCALES = ['fr', 'en'];

    public function before(RequestInterface $request, $arguments = null)
    {
        $segments = $request->getUri()->getSegments();
        $locale   = config('App')->defaultLocale;

        if ($segments !== [] && in_array($segments[0], self::LOCALES, true)) {
            $locale = $segments[0];
        }

        $request->setLocale($locale);
        session()->set('locale', $locale);

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}
