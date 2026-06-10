<?php

namespace App\Controllers\Front;

use App\Models\NewsletterSubscriberModel;

class NewsletterController extends BaseFrontController
{
    public function subscribe()
    {
        if (! $this->request->is('post')) {
            return $this->response->setStatusCode(405)->setJSON([
                'success' => false,
                'message' => $this->locale === 'fr' ? 'Méthode non autorisée.' : 'Method not allowed.',
            ]);
        }

        if (! empty($this->request->getPost('company_website'))) {
            return $this->response->setJSON([
                'success' => true,
                'message' => site_trans('newsletter_success', $this->locale),
            ]);
        }

        if ($recaptchaFail = $this->verifyRecaptchaOrFail()) {
            return $recaptchaFail;
        }

        $email = trim((string) $this->request->getPost('email'));

        if ($email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => site_trans('newsletter_error_email', $this->locale),
            ]);
        }

        $model = model(NewsletterSubscriberModel::class);

        try {
            $existing = $model->where('email', $email)->first();

            if ($existing !== null) {
                if (($existing['status'] ?? '') === 'active') {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => site_trans('newsletter_already_subscribed', $this->locale),
                    ]);
                }

                $model->update($existing['id'], [
                    'status'     => 'active',
                    'lang'       => $this->locale,
                    'ip_address' => $this->request->getIPAddress(),
                    'user_agent' => $this->request->getUserAgent()->getAgentString(),
                ]);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => site_trans('newsletter_reactivated', $this->locale),
                ]);
            }

            $model->insert([
                'email'      => $email,
                'lang'       => $this->locale,
                'ip_address' => $this->request->getIPAddress(),
                'user_agent' => $this->request->getUserAgent()->getAgentString(),
                'status'     => 'active',
            ]);
        } catch (\Throwable) {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => site_trans('newsletter_error_db', $this->locale),
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => site_trans('newsletter_success', $this->locale),
            'track'   => 'newsletter_signup',
        ]);
    }
}
