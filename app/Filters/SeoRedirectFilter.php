<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class SeoRedirectFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        return service('seo')->checkRedirect($request);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}
