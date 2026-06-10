<?php

namespace App\Controllers\Prospect;

use App\Controllers\BaseController;
use App\Models\QuoteModel;

class DashboardController extends BaseController
{
    protected $helpers = ['form', 'url', 'site'];

    public function index()
    {
        $quote = $this->currentQuote();
        if ($quote === null) {
            return redirect()->to(site_url('user/login'));
        }

        $logs = service('quote')->getLogs((int) $quote['id']);
        $documents = service('quote')->getDocuments((int) $quote['id']);

        $locale = service('request')->getLocale();
        $settings = service('siteSettings');

        return view('prospect/dashboard', [
            'title'        => site_trans('prospect_dashboard_title', $locale),
            'locale'       => $locale,
            'quote'        => $quote,
            'logs'         => $logs,
            'documents'    => $documents,
            'statusLabel'  => $this->statusLabel((string) ($quote['status'] ?? 'new')),
            'whatsappUrl'  => service('quote')->buildWhatsAppUrl(null, $locale),
            'contactEmail' => (string) ($settings->get('contact_email') ?? env('CONTACT_EMAIL', 'contact@dbdigitalagency.com')),
        ]);
    }

    public function downloadBrief()
    {
        $quote = $this->currentQuote();
        if ($quote === null) {
            return redirect()->to(site_url('user/login'));
        }

        $briefFile = (string) ($quote['brief_file'] ?? '');
        if ($briefFile === '') {
            return redirect()->back()->with('error', site_trans('prospect_no_brief'));
        }

        $paths = [
            WRITEPATH . 'uploads/' . ltrim($briefFile, '/'),
            FCPATH . '../' . ltrim($briefFile, '/'),
            ROOTPATH . ltrim($briefFile, '/'),
        ];

        foreach ($paths as $path) {
            if (is_file($path)) {
                return $this->response->download($path, null);
            }
        }

        return redirect()->back()->with('error', site_trans('prospect_no_brief'));
    }

    public function uploadDocument()
    {
        $quote = $this->currentQuote();
        if ($quote === null) {
            return redirect()->to(site_url('user/login'));
        }

        $file = $this->request->getFile('document');
        if ($file === null || ! $file->isValid()) {
            return redirect()->back()->with('error', site_trans('prospect_upload_invalid'));
        }

        $maxMb    = (int) env('QUOTE_BRIEF_MAX_MB', 2);
        $maxBytes = $maxMb * 1024 * 1024;

        if ($file->getSize() > $maxBytes) {
            return redirect()->back()->with('error', site_trans('prospect_upload_too_large'));
        }

        $upload = service('media')->upload($file, 'quotes/' . $quote['id']);
        if ($upload === null) {
            return redirect()->back()->with('error', site_trans('prospect_upload_failed'));
        }

        service('quote')->addDocument((int) $quote['id'], $upload, $file->getClientName());

        service('quote')->logAction(
            (int) $quote['id'],
            'document_upload',
            (string) ($upload['filename'] ?? $file->getClientName()),
        );

        return redirect()->back()->with('success', site_trans('prospect_upload_success'));
    }

    public function logout()
    {
        session()->remove('prospect_quote_id');

        return redirect()->to(site_url('user/login'))
            ->with('success', site_trans('prospect_logout_success'));
    }

    /**
     * @return array<string, mixed>|null
     */
    protected function currentQuote(): ?array
    {
        $quoteId = session()->get('prospect_quote_id');
        if (! $quoteId) {
            return null;
        }

        $quote = model(QuoteModel::class)->find((int) $quoteId);

        return is_array($quote) ? $quote : null;
    }

    protected function statusLabel(string $status): string
    {
        $key = 'prospect_status_' . $status;

        return site_trans($key);
    }
}
