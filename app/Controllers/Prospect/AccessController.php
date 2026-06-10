<?php

namespace App\Controllers\Prospect;

use App\Controllers\BaseController;

class AccessController extends BaseController
{
    protected $helpers = ['form', 'url', 'site'];

    public function index()
    {
        return view('prospect/access', [
            'title' => site_trans('prospect_access_title'),
        ]);
    }

    public function access(string $token)
    {
        $quoteService = service('quote');
        $quote        = $quoteService->findRawByToken($token);

        if ($quote === null) {
            return redirect()->to(site_url('user/login'))
                ->with('error', site_trans('prospect_invalid_link'));
        }

        if ($quoteService->isTokenExpired($quote)) {
            return view('prospect/expired', [
                'title'   => site_trans('prospect_expired_title'),
                'quoteId' => (int) $quote['id'],
                'email'   => (string) $quote['email'],
            ]);
        }

        $validQuote = $quoteService->findByToken($token);
        if ($validQuote === null) {
            return redirect()->to(site_url('user/login'))
                ->with('error', site_trans('prospect_invalid_link'));
        }

        session()->set('prospect_quote_id', (int) $validQuote['id']);

        return redirect()->to(site_url('prospect/dashboard'));
    }

    public function requestLink()
    {
        $rules = [
            'email' => 'required|valid_email',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $email   = strtolower(trim((string) $this->request->getPost('email')));
        $quoteId = (int) $this->request->getPost('quote_id');
        $locale  = (string) ($this->request->getPost('locale') ?? service('request')->getLocale());

        $quoteService = service('quote');
        $quote        = $quoteId > 0
            ? $quoteService->findByEmailAndId($email, $quoteId)
            : $quoteService->findLatestByEmail($email);

        $response = redirect()->to(site_url('user/login'))
            ->with('success', site_trans('prospect_magic_link_sent'));

        if ($quote === null) {
            return $response;
        }

        if ($quoteService->isTokenExpired($quote)) {
            $quoteService->refreshAccessToken((int) $quote['id']);
            $quote = $quoteService->findByEmailAndId($email, (int) $quote['id'])
                ?? $quoteService->findLatestByEmail($email)
                ?? $quote;
        }

        $quoteService->sendMagicLinkEmail($quote, $locale);

        return $response;
    }
}
