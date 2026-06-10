<?php

namespace App\Controllers\Admin;

use App\Models\QuoteModel;
use App\Services\MailService;
use App\Services\QuoteService;

class QuotesController extends BaseAdminController
{
    protected string $pageTitle  = 'Devis';
    protected string $activeMenu = 'quotes';

    protected QuoteModel $quoteModel;
    protected QuoteService $quoteService;
    protected MailService $mailService;

    public function __construct()
    {
        $this->quoteModel   = model(QuoteModel::class);
        $this->quoteService = service('quote');
        $this->mailService  = service('mailer');
    }

    public function index()
    {
        $status = (string) ($this->request->getGet('status') ?? '');
        $builder = $this->quoteModel->orderBy('created_at', 'DESC');

        if ($status !== '') {
            $builder->where('status', $status);
        }

        return $this->render('admin/quotes/index', [
            'quotes' => $builder->paginate(20),
            'pager'  => $this->quoteModel->pager,
            'status' => $status,
        ]);
    }

    public function show(int $id)
    {
        $quote = $this->quoteModel->find($id);
        if ($quote === null) {
            return redirect()->to('admin/quotes')->with('error', 'Devis introuvable.');
        }

        $logs = [];
        if ($this->quoteModel->db->tableExists('quote_logs')) {
            $logs = $this->quoteModel->db->table('quote_logs')
                ->where('quote_id', $id)
                ->orderBy('created_at', 'DESC')
                ->get()
                ->getResultArray();
        }

        $services = [];
        if ($this->quoteModel->db->tableExists('quote_services')) {
            $services = $this->quoteModel->db->table('quote_services')
                ->where('quote_id', $id)
                ->get()
                ->getResultArray();
        }

        return $this->render('admin/quotes/show', [
            'quote'    => $quote,
            'logs'     => $logs,
            'services' => $services,
            'magicUrl' => $this->magicLinkUrl($quote),
        ]);
    }

    public function update(int $id)
    {
        $quote = $this->quoteModel->find($id);
        if ($quote === null) {
            return redirect()->to('admin/quotes')->with('error', 'Devis introuvable.');
        }

        $status = (string) $this->request->getPost('status');
        $notes  = (string) $this->request->getPost('notes');
        $allowed = ['new', 'contacted', 'in_progress', 'completed', 'cancelled'];

        if (! in_array($status, $allowed, true)) {
            return redirect()->back()->with('error', 'Statut invalide.');
        }

        $this->quoteModel->update($id, [
            'status' => $status,
            'notes'  => $notes,
        ]);

        $this->quoteService->logAction($id, 'status_change', 'Statut: ' . $status);
        $this->logActivity('update', 'quote', $id, $status);

        return redirect()->to('admin/quotes/' . $id)->with('success', 'Devis mis à jour.');
    }

    public function resendMagicLink(int $id)
    {
        $quote = $this->quoteModel->find($id);
        if ($quote === null) {
            return redirect()->to('admin/quotes')->with('error', 'Devis introuvable.');
        }

        $token = $this->quoteService->generateAccessToken();
        $this->quoteModel->update($id, [
            'access_token'     => $token,
            'token_expires_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
        ]);

        $quote['access_token'] = $token;
        $url = $this->magicLinkUrl($quote);

        $sent = $this->mailService->send(
            $quote['email'],
            'Votre lien d\'accès — DB Digital Agency',
            '<p>Bonjour ' . esc($quote['fullname']) . ',</p>'
            . '<p>Voici votre lien d\'accès à votre demande de devis :</p>'
            . '<p><a href="' . esc($url, 'attr') . '">' . esc($url) . '</a></p>',
        );

        $this->quoteService->logAction($id, $sent ? 'email_sent' : 'email_failed', 'Magic link resend');
        $this->logActivity('resend_magic_link', 'quote', $id);

        return redirect()->to('admin/quotes/' . $id)->with(
            $sent ? 'success' : 'error',
            $sent ? 'Lien magique renvoyé par e-mail.' : 'Échec de l\'envoi de l\'e-mail.',
        );
    }

    /**
     * @param array<string, mixed> $quote
     */
    protected function magicLinkUrl(array $quote): string
    {
        $token = (string) ($quote['access_token'] ?? '');

        return site_url('prospect/access/' . $token);
    }
}
