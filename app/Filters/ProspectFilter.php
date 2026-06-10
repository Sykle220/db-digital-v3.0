<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ProspectFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('site');

        if (! session()->get('prospect_quote_id')) {
            return redirect()->to(site_url('user/login'))->with('error', site_trans('prospect_session_expired'));
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}
