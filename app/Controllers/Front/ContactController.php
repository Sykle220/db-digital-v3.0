<?php

namespace App\Controllers\Front;

use App\Models\ContactMessageModel;

class ContactController extends BaseFrontController
{
    public function index()
    {
        $content = service('content');

        return $this->render('front/contact', [
            'isHome'            => false,
            'pageTitle'         => site_trans('contact_page_title', $this->locale),
            'seoEntityType'     => 'contact',
            'seoEntityId'       => 1,
            'canonical'         => page_url('contact', $this->locale),
            'pageDescription'   => site_trans('contact_page_lead', $this->locale),
            'breadcrumbTitle'   => site_trans('breadcrumb_contact', $this->locale),
            'offices'           => $content->getOffices($this->locale),
            'contactDepartments'=> $content->getContactDepartments(),
        ]);
    }

    public function submit()
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
                'message' => site_trans('contact_success', $this->locale),
            ]);
        }

        if ($recaptchaFail = $this->verifyRecaptchaOrFail()) {
            return $recaptchaFail;
        }

        $name    = trim(strip_tags((string) $this->request->getPost('name')));
        $phone   = trim(strip_tags((string) $this->request->getPost('phone')));
        $email   = trim((string) $this->request->getPost('email'));
        $message = trim(strip_tags((string) $this->request->getPost('message')));

        $errors = [];
        if ($name === '') {
            $errors[] = $this->locale === 'fr' ? 'Le nom est requis.' : 'Name is required.';
        }
        if ($phone === '') {
            $errors[] = $this->locale === 'fr' ? 'Le téléphone est requis.' : 'Phone is required.';
        }
        if ($email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = $this->locale === 'fr' ? 'Email valide requis.' : 'Valid email is required.';
        }
        if ($message === '') {
            $errors[] = $this->locale === 'fr' ? 'Le message est requis.' : 'Message is required.';
        }

        if ($errors !== []) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => implode(' ', $errors),
            ]);
        }

        $model = model(ContactMessageModel::class);

        try {
            $contactId = $model->insert([
                'name'       => $name,
                'phone'      => $phone,
                'email'      => $email,
                'message'    => $message,
                'ip_address' => $this->request->getIPAddress(),
                'user_agent' => $this->request->getUserAgent()->getAgentString(),
                'status'     => 'new',
            ], true);
        } catch (\Throwable) {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => site_trans('contact_error_db', $this->locale),
            ]);
        }

        $subject = ($this->locale === 'fr' ? 'Nouveau message contact' : 'New contact message') . ' — ' . $name;
        $body    = '<html><body style="font-family:sans-serif;color:#1c4380;">'
            . '<h2>' . esc($subject) . '</h2>'
            . '<p><strong>ID:</strong> #' . (int) $contactId . '</p>'
            . '<p><strong>' . ($this->locale === 'fr' ? 'Nom' : 'Name') . ':</strong> ' . esc($name) . '</p>'
            . '<p><strong>' . ($this->locale === 'fr' ? 'Téléphone' : 'Phone') . ':</strong> ' . esc($phone) . '</p>'
            . '<p><strong>Email:</strong> ' . esc($email) . '</p>'
            . '<p><strong>Message:</strong><br>' . nl2br(esc($message)) . '</p>'
            . '</body></html>';

        $adminEmail = (string) env('ADMIN_EMAIL', 'contact@dbdigitalagency.com');
        $emailSent  = service('mailer')->send($adminEmail, $subject, $body, true, null, null, $email);

        return $this->response->setJSON([
            'success'  => true,
            'message'  => $emailSent
                ? site_trans('contact_success', $this->locale)
                : site_trans('contact_success_db_only', $this->locale),
            'track'    => 'generate_lead',
        ]);
    }
}
