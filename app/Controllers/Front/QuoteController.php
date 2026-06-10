<?php

namespace App\Controllers\Front;

class QuoteController extends BaseFrontController
{
    public function index()
    {
        $content = service('content');

        $briefMaxMb = (int) env('QUOTE_BRIEF_MAX_MB', 2);

        return $this->render('front/quote/index', [
            'isHome'            => false,
            'pageTitle'         => site_trans('quote_title', $this->locale),
            'pageDescription'   => site_trans('quote_desc', $this->locale),
            'breadcrumbTitle'   => site_trans('quote_title', $this->locale),
            'seoEntityType'     => 'quote',
            'seoEntityId'       => 1,
            'canonical'         => page_url('get-quote', $this->locale),
            'services'          => $content->getServices($this->locale),
            'offices'           => $content->getOffices($this->locale),
            'contactDepartments'=> $content->getContactDepartments(),
            'quoteErrors'       => session()->getFlashdata('quote_errors') ?? [],
            'quoteFormData'     => session()->getFlashdata('quote_form_data') ?? [],
            'quoteSuccess'      => session()->getFlashdata('quote_success') ?? false,
            'quoteEmailOk'      => session()->getFlashdata('quote_email_ok') ?? false,
            'quoteWhatsappUrl'  => session()->getFlashdata('quote_whatsapp_url') ?? '',
            'quoteBriefMaxMb'   => $briefMaxMb,
            'quoteBriefMaxBytes'=> $briefMaxMb * 1024 * 1024,
        ]);
    }

    public function submit()
    {
        if (! $this->request->is('post')) {
            return redirect()->to(page_url('get-quote', $this->locale));
        }

        if (! empty($this->request->getPost('company_website'))) {
            return redirect()->to(page_url('get-quote', $this->locale));
        }

        if ($recaptchaFail = $this->verifyRecaptchaOrFail(false)) {
            return $recaptchaFail;
        }

        $services     = $this->request->getPost('services');
        $serviceKeys  = is_array($services) ? array_map('trim', array_map('strval', $services)) : [];
        $subject      = trim((string) $this->request->getPost('subject'));
        $projectType  = trim((string) $this->request->getPost('project_type'));
        $budget       = trim((string) $this->request->getPost('budget'));
        $startDate    = trim((string) $this->request->getPost('start_date'));
        $website      = trim((string) $this->request->getPost('website'));
        $message      = trim((string) $this->request->getPost('message'));
        $fullname     = trim((string) $this->request->getPost('fullname'));
        $company      = trim((string) $this->request->getPost('company'));
        $email        = trim((string) $this->request->getPost('email'));
        $whatsapp     = trim((string) $this->request->getPost('whatsapp'));

        $errors = [];
        if ($serviceKeys === []) {
            $errors[] = site_trans('quote_validation_select_service', $this->locale);
        }
        if ($subject === '') {
            $errors[] = site_trans('quote_subject_label', $this->locale) . ' ' . site_trans('quote_validation_required', $this->locale);
        }
        if ($projectType === '') {
            $errors[] = site_trans('quote_type_label', $this->locale) . ' ' . site_trans('quote_validation_required', $this->locale);
        }
        if ($budget === '') {
            $errors[] = site_trans('quote_budget_label', $this->locale) . ' ' . site_trans('quote_validation_required', $this->locale);
        }
        if ($startDate === '') {
            $errors[] = site_trans('quote_start_label', $this->locale) . ' ' . site_trans('quote_validation_required', $this->locale);
        }
        if ($fullname === '') {
            $errors[] = site_trans('quote_fullname_label', $this->locale) . ' ' . site_trans('quote_validation_required', $this->locale);
        }
        if ($email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = site_trans('quote_validation_email', $this->locale);
        }
        if ($whatsapp === '') {
            $errors[] = site_trans('quote_whatsapp_label', $this->locale) . ' ' . site_trans('quote_validation_required', $this->locale);
        }
        if ($website !== '' && ! filter_var($website, FILTER_VALIDATE_URL)) {
            $errors[] = $this->locale === 'fr' ? 'URL de site invalide' : 'Invalid website URL';
        }

        $briefFile = $this->request->getFile('project_brief');
        $maxMb     = (int) env('QUOTE_BRIEF_MAX_MB', 2);
        $maxBytes  = $maxMb * 1024 * 1024;

        if ($briefFile && $briefFile->isValid() && ! $briefFile->hasMoved()) {
            if ($briefFile->getSize() > $maxBytes) {
                $errors[] = sprintf(site_trans('quote_validation_file_size', $this->locale), $maxMb);
            }
        }

        if ($errors !== []) {
            session()->setFlashdata('quote_errors', $errors);
            session()->setFlashdata('quote_form_data', $this->request->getPost());

            return redirect()->to(page_url('get-quote', $this->locale));
        }

        $quoteService = service('quote');
        $quote = $quoteService->save([
            'service'      => implode(', ', $serviceKeys),
            'subject'      => $subject,
            'project_type' => $projectType,
            'budget'       => $budget,
            'start_date'   => $startDate,
            'website'      => $website,
            'message'      => $message,
            'fullname'     => $fullname,
            'company'      => $company,
            'email'        => $email,
            'whatsapp'     => $whatsapp,
        ], $serviceKeys, $briefFile);

        if ($quote === null) {
            session()->setFlashdata('quote_errors', [site_trans('quote_error_db', $this->locale)]);
            session()->setFlashdata('quote_form_data', $this->request->getPost());

            return redirect()->to(page_url('get-quote', $this->locale));
        }

        $waMessage = site_trans('quote_whatsapp_intro', $this->locale) . "\n\n"
            . site_trans('quote_whatsapp_service', $this->locale) . ': ' . implode(', ', $serviceKeys) . "\n"
            . site_trans('quote_whatsapp_subject', $this->locale) . ': ' . $subject . "\n"
            . site_trans('quote_whatsapp_type', $this->locale) . ': ' . $projectType . "\n"
            . site_trans('quote_whatsapp_budget', $this->locale) . ': ' . $budget . "\n"
            . site_trans('quote_whatsapp_start', $this->locale) . ': ' . $startDate . "\n"
            . site_trans('quote_whatsapp_name', $this->locale) . ': ' . $fullname . "\n"
            . ($company !== '' ? site_trans('quote_whatsapp_company', $this->locale) . ': ' . $company . "\n" : '')
            . site_trans('quote_whatsapp_email', $this->locale) . ': ' . $email . "\n"
            . ($message !== '' ? site_trans('quote_whatsapp_message', $this->locale) . ': ' . $message : '');

        $whatsappUrl = $quoteService->buildWhatsAppUrl($waMessage, $this->locale);

        $adminEmail = (string) env('ADMIN_EMAIL', 'contact@dbdigitalagency.com');
        $subjectMail = ($this->locale === 'fr' ? 'Nouvelle demande de devis' : 'New quote request') . ' — ' . $fullname;
        $body = '<html><body style="font-family:sans-serif;">'
            . '<h2>' . esc($subjectMail) . '</h2>'
            . '<p><strong>Services:</strong> ' . esc(implode(', ', $serviceKeys)) . '</p>'
            . '<p><strong>Subject:</strong> ' . esc($subject) . '</p>'
            . '<p><strong>Name:</strong> ' . esc($fullname) . '</p>'
            . '<p><strong>Email:</strong> ' . esc($email) . '</p>'
            . '<p><strong>WhatsApp:</strong> ' . esc($whatsapp) . '</p>'
            . '</body></html>';

        $emailOk = service('mailer')->send($adminEmail, $subjectMail, $body, true, null, null, $email);

        $quoteService->sendMagicLinkEmail($quote, $this->locale);

        session()->setFlashdata('quote_success', true);
        session()->setFlashdata('quote_email_ok', $emailOk);
        session()->setFlashdata('quote_whatsapp_url', $whatsappUrl);

        return redirect()->to(page_url('get-quote', $this->locale) . '/success');
    }

    public function success()
    {
        return $this->render('front/quote/success', [
            'isHome'           => false,
            'pageTitle'        => site_trans('quote_title', $this->locale),
            'pageDescription'  => site_trans('meta_default_description', $this->locale),
            'breadcrumbTitle'  => site_trans('quote_title', $this->locale),
            'quoteEmailOk'     => session()->getFlashdata('quote_email_ok') ?? false,
            'quoteWhatsappUrl' => session()->getFlashdata('quote_whatsapp_url') ?? service('quote')->buildWhatsAppUrl(null, $this->locale),
            'trackConversion'  => 'quote_submit',
        ]);
    }
}
