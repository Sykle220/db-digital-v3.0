<?php

namespace App\Controllers\Front;

use CodeIgniter\HTTP\ResponseInterface;

class ErrorsController extends BaseFrontController
{
    public function show404(mixed ...$args): ResponseInterface
    {
        $message = isset($args[0]) && is_string($args[0]) ? $args[0] : null;

        return $this->response
            ->setStatusCode(404)
            ->setBody($this->render404($message));
    }

    public function render404(?string $debugMessage = null): string
    {
        $this->locale = $this->resolveLocaleFor404();
        $this->request->setLocale($this->locale);
        $this->shared = $this->buildSharedData();

        return $this->render('front/errors/404', [
            'pageTitle'       => site_trans('error_404_title', $this->locale),
            'pageDescription' => site_trans('error_404_description', $this->locale),
            'breadcrumbTitle' => site_trans('error_404_breadcrumb', $this->locale),
            'seoIndex'        => false,
            'debugMessage'    => ENVIRONMENT !== 'production' ? $debugMessage : null,
        ]);
    }

    protected function resolveLocaleFor404(): string
    {
        $segments = $this->request->getUri()->getSegments();

        if (isset($segments[0]) && in_array($segments[0], ['fr', 'en'], true)) {
            return $segments[0];
        }

        $sessionLocale = session()->get('locale');

        if (is_string($sessionLocale) && in_array($sessionLocale, ['fr', 'en'], true)) {
            return $sessionLocale;
        }

        return config('App')->defaultLocale;
    }
}
