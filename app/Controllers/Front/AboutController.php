<?php

namespace App\Controllers\Front;

class AboutController extends BaseFrontController
{
    public function index()
    {
        $content = service('content');

        return $this->render('front/about', [
            'isHome'          => false,
            'pageTitle'       => site_trans('about_page_title', $this->locale),
            'pageDescription' => site_trans('about_page_desc', $this->locale),
            'breadcrumbTitle' => site_trans('breadcrumb_about', $this->locale),
            'seoEntityType'   => 'page',
            'seoEntityId'     => 1,
            'canonical'       => page_url('about', $this->locale),
            'aboutSkills'     => $content->getAboutSkills(),
            'team'            => $content->getTeam($this->locale),
        ]);
    }
}
