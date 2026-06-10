<?php

namespace App\Controllers\Front;

class CityController extends BaseFrontController
{
    public function show(string $citySlug)
    {
        $content = service('content');
        $office  = $content->getOfficeBySlug($citySlug, $this->locale);

        if ($office === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $cityName = (string) ($office['city'] ?? ucfirst($citySlug));
        $title    = $this->locale === 'fr'
            ? 'Agence digitale à ' . $cityName
            : 'Digital agency in ' . $cityName;
        $description = $this->locale === 'fr'
            ? 'DB Digital Agency accompagne les entreprises à ' . $cityName . ' : stratégie digitale, web, branding, SEO et acquisition.'
            : 'DB Digital Agency supports businesses in ' . $cityName . ' with digital strategy, web, branding, SEO and acquisition.';

        $cityPath = $this->locale === 'fr'
            ? 'agence-digitale/' . $citySlug
            : 'digital-agency/' . $citySlug;

        return $this->render('front/city', [
            'isHome'          => false,
            'pageTitle'       => $title,
            'pageDescription' => $description,
            'breadcrumbTitle' => $cityName,
            'seoEntityType'   => 'office',
            'seoEntityId'     => (int) ($office['id'] ?? 0),
            'canonical'       => site_url($this->locale . '/' . $cityPath),
            'seoSchemas'      => [
                service('schema')->localBusiness($office, $this->locale, (string) ($this->shared['siteName'] ?? 'DB Digital Agency')),
                service('schema')->breadcrumbList([
                    ['label' => site_trans('nav_home', $this->locale), 'url' => page_url('home', $this->locale)],
                    ['label' => $title],
                ]),
            ],
            'office'          => $office,
            'cityName'        => $cityName,
            'services'        => $content->getServices($this->locale),
        ]);
    }
}
