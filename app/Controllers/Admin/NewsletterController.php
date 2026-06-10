<?php

namespace App\Controllers\Admin;

use App\Models\NewsletterSubscriberModel;

class NewsletterController extends BaseAdminController
{
    protected string $pageTitle  = 'Newsletter';
    protected string $activeMenu = 'newsletter';

    protected NewsletterSubscriberModel $model;

    public function __construct()
    {
        $this->model = model(NewsletterSubscriberModel::class);
    }

    public function index()
    {
        $status = (string) ($this->request->getGet('status') ?? '');
        $builder = $this->model->orderBy('created_at', 'DESC');

        if ($status !== '') {
            $builder->where('status', $status);
        }

        return $this->render('admin/newsletter/index', [
            'subscribers' => $builder->paginate(30),
            'pager'       => $this->model->pager,
            'status'      => $status,
        ]);
    }

    public function export()
    {
        $rows = $this->model->where('status', 'active')->orderBy('created_at', 'DESC')->findAll();

        $csv = "email,lang,created_at\n";
        foreach ($rows as $row) {
            $csv .= sprintf(
                "%s,%s,%s\n",
                str_replace(',', ' ', (string) $row['email']),
                (string) ($row['lang'] ?? 'fr'),
                (string) ($row['created_at'] ?? ''),
            );
        }

        $this->logActivity('export', 'newsletter');

        return $this->response
            ->setHeader('Content-Type', 'text/csv; charset=utf-8')
            ->setHeader('Content-Disposition', 'attachment; filename="newsletter-' . date('Y-m-d') . '.csv"')
            ->setBody($csv);
    }
}
