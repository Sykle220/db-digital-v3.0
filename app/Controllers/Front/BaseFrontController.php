<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseFrontController extends BaseController
{
    protected string $locale = 'fr';

    /**
     * @var array<string, mixed>
     */
    protected array $shared = [];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        $this->helpers = ['url', 'form', 'site'];

        parent::initController($request, $response, $logger);

        $this->locale = $request->getLocale();
        $this->shared = $this->buildSharedData();
    }

    /**
     * @param array<string, mixed> $data
     */
    protected function render(string $view, array $data = []): string
    {
        if (! isset($data['pageSeo'])) {
            $data['pageSeo'] = $this->buildPageSeo([
                'title'       => (string) ($data['pageTitle'] ?? ''),
                'description' => (string) ($data['pageDescription'] ?? ''),
                'entityType'  => $data['seoEntityType'] ?? null,
                'entityId'    => (int) ($data['seoEntityId'] ?? 0),
                'ogImage'     => $data['ogImage'] ?? null,
                'ogType'      => $data['ogType'] ?? 'website',
                'schemas'     => $data['seoSchemas'] ?? [],
                'canonical'   => $data['canonical'] ?? current_url(),
            ]);
        }

        return view($view, array_merge($this->shared, $data));
    }

    /**
     * @return array<string, mixed>
     */
    protected function buildSharedData(): array
    {
        $menu     = service('menu');
        $branding = service('branding');
        $settings = service('siteSettings');
        $navItems = $menu->buildTree('header', $this->locale);

        if ($navItems === []) {
            $navItems = $this->defaultNavItems();
        }

        $logoLight = $branding->getLogoLight() ?? asset_url('img/logo/w_logo02.png');
        $logoDark  = $branding->getLogoDark() ?? asset_url('img/logo/logo.png');
        $favicon   = $branding->getFavicon() ?? asset_url('img/favicon.png');

        $siteSettings = $settings->all([
            'site_name'        => (string) env('SITE_NAME', 'DB Digital Agency'),
            'contact_address'  => (string) env('CONTACT_ADDRESS', 'Entrée Carriere, Nkoabang, Yaoundé, Cameroon'),
            'contact_phone_1'  => (string) env('CONTACT_PHONE_1', '+237 691 323 249'),
            'contact_phone_2'  => (string) env('CONTACT_PHONE_2', '+237 658 910 343'),
            'contact_email'    => (string) env('CONTACT_EMAIL', 'contact@dbdigitalagency.com'),
            'whatsapp_number'  => (string) env('WHATSAPP_NUMBER', '237691323249'),
            'seo_index'        => (string) env('SEO_INDEX', 'true'),
        ]);

        return [
            'locale'          => $this->locale,
            'navItems'        => $navItems,
            'branding'        => $branding->getBranding(),
            'logoLight'       => $logoLight,
            'logoDark'        => $logoDark,
            'favicon'         => $favicon,
            'siteName'        => $siteSettings['site_name'] ?? 'DB Digital Agency',
            'contactAddress'  => $siteSettings['contact_address'] ?? '',
            'contactPhone1'   => $siteSettings['contact_phone_1'] ?? $siteSettings['contact_phone'] ?? '',
            'contactPhone2'   => $siteSettings['contact_phone_2'] ?? '',
            'contactEmail'    => $siteSettings['contact_email'] ?? '',
            'whatsappNumber'  => $siteSettings['whatsapp_number'] ?? '',
            'whatsappMessage' => site_trans('whatsapp_default_message', $this->locale),
            'socialLinks'     => $settings->socialLinks(),
            'seoIndex'        => filter_var($siteSettings['seo_index'] ?? true, FILTER_VALIDATE_BOOLEAN),
            'quoteBriefMaxMb' => (int) env('QUOTE_BRIEF_MAX_MB', 2),
            'integrations'    => $settings->integrations(),
            'recaptchaSiteKey'=> service('recaptcha')->siteKey(),
            'recaptchaOn'     => service('recaptcha')->isEnabled(),
        ];
    }

    /**
     * @param array<string, mixed> $options
     *
     * @return array<string, mixed>
     */
    protected function buildPageSeo(array $options): array
    {
        $options['locale']   = $options['locale'] ?? $this->locale;
        $options['siteName'] = $options['siteName'] ?? ($this->shared['siteName'] ?? 'DB Digital Agency');
        $options['seoIndex'] = $options['seoIndex'] ?? ($this->shared['seoIndex'] ?? true);

        $schemas = $options['schemas'] ?? [];
        $org     = service('schema')->organization([
            'name'    => $options['siteName'],
            'email'   => $this->shared['contactEmail'] ?? '',
            'phone'   => $this->shared['contactPhone1'] ?? '',
            'address' => $this->shared['contactAddress'] ?? '',
        ]);
        array_unshift($schemas, $org);
        $options['schemas'] = $schemas;

        return service('seoPresentation')->build($options);
    }

    /**
     * @return list<array<string, mixed>>
     */
    protected function defaultNavItems(): array
    {
        return [
            ['label' => site_trans('nav_home', $this->locale), 'url' => page_url('home', $this->locale), 'css_class' => ''],
            ['label' => site_trans('nav_about', $this->locale), 'url' => page_url('about', $this->locale), 'css_class' => ''],
            ['label' => site_trans('nav_services', $this->locale), 'url' => page_url('services', $this->locale), 'css_class' => ''],
            ['label' => site_trans('nav_projects', $this->locale), 'url' => page_url('projects', $this->locale), 'css_class' => ''],
            ['label' => site_trans('nav_contact', $this->locale), 'url' => page_url('contact', $this->locale), 'css_class' => ''],
        ];
    }

    /**
     * @param array<string, mixed> $overrides
     *
     * @return array<string, mixed>
     */
    protected function seoMeta(string $entityType, int $entityId, array $overrides = []): array
    {
        $seo  = service('seo');
        $meta = $seo->getMeta($entityType, $entityId, $this->locale) ?? [];

        return array_merge($meta, $overrides);
    }

    /**
     * @return \CodeIgniter\HTTP\ResponseInterface|null
     */
    protected function verifyRecaptchaOrFail(bool $json = true)
    {
        if (! service('recaptcha')->isEnabled()) {
            return null;
        }

        $ok = service('recaptcha')->verify(
            $this->request->getPost('g-recaptcha-response'),
            $this->request->getIPAddress(),
        );

        if ($ok) {
            return null;
        }

        $message = $this->locale === 'fr'
            ? 'Vérification anti-spam échouée. Réessayez.'
            : 'Anti-spam verification failed. Please try again.';

        if ($json) {
            return $this->response->setStatusCode(422)->setJSON([
                'success' => false,
                'message' => $message,
            ]);
        }

        return redirect()->back()->with('error', $message);
    }
}
