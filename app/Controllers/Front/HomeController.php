<?php

namespace App\Controllers\Front;

class HomeController extends BaseFrontController
{
    public function index()
    {
        $content = service('content');

        $services      = $content->getServices($this->locale);
        $projects      = $content->getHomepageProjects($this->locale);
        $team          = $content->getTeam($this->locale);
        $testimonials  = $content->getTestimonials($this->locale);
        $brandLogos    = $content->getBrandLogos();
        $features      = $content->getHomepageFeatures($this->locale);
        $counters      = $content->getHomepageCounters();
        $leadership    = $content->getCompanyLeadership();

        return $this->render('front/home', [
            'isHome'         => true,
            'pageTitle'      => $this->locale === 'fr' ? 'Accueil' : 'Home',
            'pageDescription'=> site_trans('meta_default_description', $this->locale),
            'seoEntityType'  => 'home',
            'seoEntityId'    => 1,
            'canonical'      => page_url('home', $this->locale),
            'services'       => $services,
            'projects'       => $projects,
            'team'           => $team,
            'testimonials'   => $testimonials,
            'brandLogos'     => $brandLogos,
            'features'       => $features,
            'counters'       => $counters,
            'leadership'     => $leadership,
        ]);
    }
}
