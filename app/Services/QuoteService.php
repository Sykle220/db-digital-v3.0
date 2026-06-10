<?php

namespace App\Services;

use App\Models\QuoteModel;
use CodeIgniter\HTTP\Files\UploadedFile;

class QuoteService
{
    protected QuoteModel $quoteModel;
    protected MediaService $mediaService;

    public function __construct(?QuoteModel $quoteModel = null, ?MediaService $mediaService = null)
    {
        $this->quoteModel   = $quoteModel ?? model(QuoteModel::class);
        $this->mediaService = $mediaService ?? service('media');
    }

    /**
     * @param array<string, mixed> $data
     * @param list<string>         $serviceKeys
     *
     * @return array<string, mixed>|null
     */
    public function save(array $data, array $serviceKeys = [], ?UploadedFile $briefFile = null): ?array
    {
        $briefPath = null;
        if ($briefFile instanceof UploadedFile && $briefFile->isValid()) {
            $upload = $this->mediaService->upload($briefFile, 'quotes');
            $briefPath = $upload['filename'] ?? null;
        }

        $token     = $this->generateAccessToken();
        $expiresAt = date('Y-m-d H:i:s', strtotime('+30 days'));

        $quoteId = $this->quoteModel->insert([
            'service'          => $data['service'] ?? implode(', ', $serviceKeys),
            'subject'          => $data['subject'] ?? '',
            'project_type'     => $data['project_type'] ?? '',
            'budget'           => $data['budget'] ?? '',
            'start_date'       => $data['start_date'] ?? '',
            'website'          => $data['website'] ?? null,
            'message'          => $data['message'] ?? null,
            'brief_file'       => $briefPath ?? ($data['brief_file'] ?? null),
            'fullname'         => $data['fullname'] ?? '',
            'company'          => $data['company'] ?? null,
            'email'            => $data['email'] ?? '',
            'whatsapp'         => $data['whatsapp'] ?? '',
            'ip_address'       => $data['ip_address'] ?? service('request')->getIPAddress(),
            'user_agent'       => $data['user_agent'] ?? service('request')->getUserAgent()->getAgentString(),
            'access_token'     => $token,
            'token_expires_at' => $expiresAt,
            'status'           => 'new',
        ], true);

        if (! $quoteId) {
            return null;
        }

        foreach ($serviceKeys as $serviceKey) {
            $this->quoteModel->db->table('quote_services')->insert([
                'quote_id'    => $quoteId,
                'service_key' => $serviceKey,
                'created_at'  => date('Y-m-d H:i:s'),
            ]);
        }

        $quote = $this->quoteModel->find($quoteId);
        $this->logAction((int) $quoteId, 'status_change', 'Quote created');

        return is_array($quote) ? $quote : null;
    }

    public function generateAccessToken(): string
    {
        do {
            $token = bin2hex(random_bytes(32));
            $exists = $this->quoteModel->where('access_token', $token)->first();
        } while ($exists !== null);

        return $token;
    }

    public function logAction(int $quoteId, string $actionType, ?string $details = null): void
    {
        if (! $this->quoteModel->db->tableExists('quote_logs')) {
            return;
        }

        $allowed = ['email_sent', 'whatsapp_click', 'email_failed', 'prospect_access', 'status_change', 'document_upload'];
        if (! in_array($actionType, $allowed, true)) {
            $actionType = 'prospect_access';
        }

        $this->quoteModel->db->table('quote_logs')->insert([
            'quote_id'       => $quoteId,
            'action_type'    => $actionType,
            'action_details' => $details,
            'created_at'     => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Construit l'URL WhatsApp avec message prérempli.
     */
    public function buildWhatsAppUrl(?string $message = null, ?string $locale = null): string
    {
        $number = preg_replace('/\D+/', '', (string) env('WHATSAPP_NUMBER', '237691323249'));

        if ($message === null) {
            $locale  = $locale ?? service('request')->getLocale();
            $message = site_trans('whatsapp_default_message', $locale);
        }

        return 'https://wa.me/' . $number . '?text=' . rawurlencode($message);
    }

    public function findByToken(string $token): ?array
    {
        $quote = $this->quoteModel->where('access_token', $token)->first();

        if ($quote === null) {
            return null;
        }

        if ($this->isTokenExpired($quote)) {
            return null;
        }

        $this->quoteModel->update($quote['id'], [
            'last_accessed_at' => date('Y-m-d H:i:s'),
        ]);

        $this->logAction((int) $quote['id'], 'prospect_access', 'Magic link access');

        return $quote;
    }

    public function findRawByToken(string $token): ?array
    {
        $quote = $this->quoteModel->where('access_token', $token)->first();

        return is_array($quote) ? $quote : null;
    }

    public function isTokenExpired(array $quote): bool
    {
        return ! empty($quote['token_expires_at'])
            && strtotime((string) $quote['token_expires_at']) < time();
    }

    public function findByEmailAndId(string $email, int $quoteId): ?array
    {
        $quote = $this->quoteModel
            ->where('id', $quoteId)
            ->where('email', $email)
            ->first();

        return is_array($quote) ? $quote : null;
    }

    public function findLatestByEmail(string $email): ?array
    {
        $email = strtolower(trim($email));
        if ($email === '') {
            return null;
        }

        $quote = $this->quoteModel
            ->where('email', $email)
            ->orderBy('created_at', 'DESC')
            ->first();

        return is_array($quote) ? $quote : null;
    }

    public function refreshAccessToken(int $quoteId): ?string
    {
        $token     = $this->generateAccessToken();
        $expiresAt = date('Y-m-d H:i:s', strtotime('+30 days'));

        $updated = $this->quoteModel->update($quoteId, [
            'access_token'     => $token,
            'token_expires_at' => $expiresAt,
        ]);

        if (! $updated) {
            return null;
        }

        $this->logAction($quoteId, 'email_sent', 'Access token refreshed');

        return $token;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getDocuments(int $quoteId): array
    {
        if (! $this->quoteModel->db->tableExists('quote_documents')) {
            return [];
        }

        return $this->quoteModel->db->table('quote_documents')
            ->where('quote_id', $quoteId)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * @param array<string, mixed> $upload
     */
    public function addDocument(int $quoteId, array $upload, ?string $originalName = null): bool
    {
        if (! $this->quoteModel->db->tableExists('quote_documents')) {
            return false;
        }

        $filename = (string) ($upload['filename'] ?? '');
        if ($filename === '') {
            return false;
        }

        return (bool) $this->quoteModel->db->table('quote_documents')->insert([
            'quote_id'      => $quoteId,
            'filename'      => $filename,
            'original_name' => $originalName,
            'created_at'    => date('Y-m-d H:i:s'),
        ]);
    }

    public function translateLogAction(string $actionType): string
    {
        $key = 'prospect_log_' . $actionType;
        $label = site_trans($key);

        return $label !== $key ? $label : $actionType;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getLogs(int $quoteId): array
    {
        if (! $this->quoteModel->db->tableExists('quote_logs')) {
            return [];
        }

        return $this->quoteModel->db->table('quote_logs')
            ->where('quote_id', $quoteId)
            ->orderBy('created_at', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function sendMagicLinkEmail(array $quote, ?string $locale = null): bool
    {
        $locale = $locale ?? 'fr';
        $token  = (string) ($quote['access_token'] ?? '');

        if ($token === '') {
            $token = $this->refreshAccessToken((int) $quote['id']) ?? '';
        }

        if ($token === '') {
            return false;
        }

        $link    = site_url('prospect/access/' . $token);
        $subject = $locale === 'fr'
            ? 'Votre espace de suivi de devis — DB Digital Agency'
            : 'Your quote tracking portal — DB Digital Agency';

        $body = $this->buildMagicLinkEmailBody($quote, $link, $locale);

        $sent = service('mailer')->send(
            (string) $quote['email'],
            $subject,
            $body,
            true,
            null,
            null,
            (string) env('ADMIN_EMAIL', 'contact@dbdigitalagency.com'),
        );

        $this->logAction(
            (int) $quote['id'],
            $sent ? 'email_sent' : 'email_failed',
            $sent ? 'Magic link email sent' : 'Magic link email failed',
        );

        return $sent;
    }

    /**
     * @param array<string, mixed> $quote
     */
    protected function buildMagicLinkEmailBody(array $quote, string $link, string $locale): string
    {
        $name    = esc((string) ($quote['fullname'] ?? ''));
        $quoteId = (int) ($quote['id'] ?? 0);

        if ($locale === 'fr') {
            return <<<HTML
<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body style="font-family:Arial,sans-serif;background:#f5f5f5;padding:24px;">
<div style="max-width:560px;margin:0 auto;background:#fff;padding:32px;border-radius:8px;">
<h2 style="color:#1e3a5f;margin-top:0;">Suivez votre demande de devis</h2>
<p>Bonjour {$name},</p>
<p>Consultez le statut de votre devis <strong>#{$quoteId}</strong> et partagez des documents complémentaires via votre espace sécurisé.</p>
<p style="text-align:center;margin:28px 0;">
<a href="{$link}" style="background:#534AB7;color:#fff;padding:12px 24px;text-decoration:none;border-radius:6px;display:inline-block;">Accéder à mon espace</a>
</p>
<p style="color:#666;font-size:13px;">Ce lien est valable 30 jours. Si vous n'êtes pas à l'origine de cette demande, ignorez cet e-mail.</p>
</div></body></html>
HTML;
        }

        return <<<HTML
<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body style="font-family:Arial,sans-serif;background:#f5f5f5;padding:24px;">
<div style="max-width:560px;margin:0 auto;background:#fff;padding:32px;border-radius:8px;">
<h2 style="color:#1e3a5f;margin-top:0;">Track your quote request</h2>
<p>Hello {$name},</p>
<p>View the status of quote <strong>#{$quoteId}</strong> and upload additional documents from your secure portal.</p>
<p style="text-align:center;margin:28px 0;">
<a href="{$link}" style="background:#534AB7;color:#fff;padding:12px 24px;text-decoration:none;border-radius:6px;display:inline-block;">Open my portal</a>
</p>
<p style="color:#666;font-size:13px;">This link is valid for 30 days. If you did not request this, please ignore this email.</p>
</div></body></html>
HTML;
    }
}
