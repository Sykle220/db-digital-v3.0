<?php

namespace App\Controllers\Front;

class ProjectsController extends BaseFrontController
{
    public function index()
    {
        $content  = service('content');
        $projects = $content->getProjects($this->locale);

        if ($projects === []) {
            $projects = $content->getHomepageProjects($this->locale);
        }

        return $this->render('front/projects/index', [
            'isHome'          => false,
            'pageTitle'       => site_trans('breadcrumb_projects', $this->locale),
            'pageDescription' => site_trans('projects_title', $this->locale),
            'breadcrumbTitle' => site_trans('breadcrumb_projects', $this->locale),
            'seoEntityType'   => 'project',
            'seoEntityId'     => 1,
            'canonical'       => page_url('projects', $this->locale),
            'projects'        => $projects,
            'brandLogos'      => $content->getBrandLogos(),
        ]);
    }
}
