<?php

namespace App\Controllers\Admin;

use App\Models\ContactMessageModel;
use App\Models\NewsletterSubscriberModel;
use App\Models\QuoteModel;

class DashboardController extends BaseAdminController
{
    protected string $pageTitle  = 'Tableau de bord';
    protected string $activeMenu = 'dashboard';

    public function index()
    {
        $quoteModel      = model(QuoteModel::class);
        $contactModel    = model(ContactMessageModel::class);
        $newsletterModel = model(NewsletterSubscriberModel::class);

        $recentActivity = [];
        if ($this->activityModel->db->tableExists('admin_activity_log')) {
            $recentActivity = $this->activityModel
                ->orderBy('created_at', 'DESC')
                ->limit(10)
                ->findAll();
        }

        return $this->render('admin/dashboard', [
            'kpis' => [
                'new_quotes'    => $quoteModel->where('status', 'new')->countAllResults(),
                'unread_contacts' => $contactModel->where('status', 'new')->countAllResults(),
                'newsletter'    => $newsletterModel->where('status', 'active')->countAllResults(),
            ],
            'recentQuotes'   => $quoteModel->orderBy('created_at', 'DESC')->limit(5)->findAll(),
            'recentContacts' => $contactModel->orderBy('created_at', 'DESC')->limit(5)->findAll(),
            'recentActivity' => $recentActivity,
        ]);
    }
}
