<?php

namespace App\Services;

use CodeIgniter\HTTP\CURLRequest;

class RecaptchaService
{
    protected SiteSettingsService $settings;

    public function __construct(?SiteSettingsService $settings = null)
    {
        $this->settings = $settings ?? service('siteSettings');
    }

    public function isEnabled(): bool
    {
        return filter_var($this->settings->get('recaptcha_enabled', '0'), FILTER_VALIDATE_BOOLEAN)
            && $this->siteKey() !== ''
            && $this->secretKey() !== '';
    }

    public function siteKey(): string
    {
        return trim($this->settings->get('recaptcha_site_key', (string) env('RECAPTCHA_SITE_KEY', '')));
    }

    public function secretKey(): string
    {
        return trim((string) env('RECAPTCHA_SECRET_KEY', $this->settings->get('recaptcha_secret_key', '')));
    }

    public function verify(?string $token, ?string $remoteIp = null): bool
    {
        if (! $this->isEnabled()) {
            return true;
        }

        if ($token === null || $token === '') {
            return false;
        }

        $secret = $this->secretKey();
        if ($secret === '') {
            return false;
        }

        /** @var CURLRequest $client */
        $client = service('curlrequest', ['timeout' => 5]);

        try {
            $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
                'form_params' => [
                    'secret'   => $secret,
                    'response' => $token,
                    'remoteip' => $remoteIp,
                ],
            ]);
            $body = json_decode((string) $response->getBody(), true);

            return is_array($body)
                && ($body['success'] ?? false) === true
                && ((float) ($body['score'] ?? 0)) >= 0.5;
        } catch (\Throwable) {
            log_message('error', 'reCAPTCHA verification failed');

            return false;
        }
    }
}
