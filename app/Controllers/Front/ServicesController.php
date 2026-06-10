<?php

namespace App\Controllers\Front;

class ServicesController extends BaseFrontController
{
    public function index()
    {
        $content  = service('content');
        $services = $content->getServices($this->locale);

        return $this->render('front/services/index', [
            'isHome'          => false,
            'pageTitle'       => site_trans('services_page_title', $this->locale),
            'pageDescription' => site_trans('services_page_lead', $this->locale),
            'breadcrumbTitle' => site_trans('breadcrumb_services', $this->locale),
            'seoEntityType'   => 'services_index',
            'seoEntityId'     => 1,
            'canonical'       => page_url('services', $this->locale),
            'services'        => $services,
            'brandLogos'      => $content->getBrandLogos(),
        ]);
    }

    public function detail(string $slug)
    {
        $content = service('content');
        $service = $content->getServiceBySlug($slug, $this->locale);
        $services = $content->getServices($this->locale);

        if ($service === null) {
            if ($services !== []) {
                return redirect()->to(service_url((string) $services[0]['slug'], $this->locale));
            }

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $benefits = lang_field($service, 'benefits', $this->locale);
        if (is_string($benefits)) {
            $decoded = json_decode($benefits, true);
            $benefits = is_array($decoded) ? $decoded : [];
        }
        if (! is_array($benefits)) {
            $benefits = [];
        }

        $faqItems = $service['faq'] ?? [];
        $faqSchema = [];
        foreach ($faqItems as $item) {
            $faqSchema[] = [
                'question' => (string) ($item['question_' . $this->locale] ?? $item['q_' . $this->locale] ?? ''),
                'answer'   => (string) ($item['answer_' . $this->locale] ?? $item['a_' . $this->locale] ?? ''),
            ];
        }

        $schemas = [
            service('schema')->breadcrumbList([
                ['label' => site_trans('nav_home', $this->locale), 'url' => page_url('home', $this->locale)],
                ['label' => site_trans('breadcrumb_services', $this->locale), 'url' => page_url('services', $this->locale)],
                ['label' => lang_field($service, 'title', $this->locale)],
            ]),
        ];
        if ($faqSchema !== []) {
            $schemas[] = service('schema')->faqPage($faqSchema);
        }

        $image = (string) ($service['image'] ?? '');
        $ogImage = $image !== '' && ! str_starts_with($image, 'http')
            ? asset_url('img/services/' . ltrim($image, '/'))
            : null;

        return $this->render('front/services/detail', [
            'isHome'          => false,
            'pageTitle'       => lang_field($service, 'title', $this->locale),
            'pageDescription' => lang_field($service, 'description', $this->locale),
            'breadcrumbTitle' => lang_field($service, 'title', $this->locale),
            'seoEntityType'   => 'service',
            'seoEntityId'     => (int) ($service['id'] ?? 0),
            'seoSchemas'      => $schemas,
            'ogImage'         => $ogImage,
            'canonical'       => service_url((string) $service['slug'], $this->locale),
            'service'         => $service,
            'services'        => $services,
            'benefits'        => $benefits,
            'faqItems'        => $faqItems,
            'brandLogos'      => $content->getBrandLogos(),
        ]);
    }
}
