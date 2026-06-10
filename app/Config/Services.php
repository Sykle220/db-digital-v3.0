<?php

namespace Config;

use App\Services\BrandingService;
use App\Services\ContentService;
use App\Services\MailService;
use App\Services\MediaService;
use App\Services\MenuService;
use App\Services\QuoteService;
use App\Services\RecaptchaService;
use App\Services\SchemaService;
use App\Services\SeoPresentationService;
use App\Services\SeoService;
use App\Services\SiteSettingsService;
use App\Services\TranslationService;
use CodeIgniter\Config\BaseService;

class Services extends BaseService
{
    public static function translation(bool $getShared = true): TranslationService
    {
        if ($getShared) {
            return static::getSharedInstance('translation');
        }

        return new TranslationService();
    }

    public static function menu(bool $getShared = true): MenuService
    {
        if ($getShared) {
            return static::getSharedInstance('menu');
        }

        return new MenuService();
    }

    public static function branding(bool $getShared = true): BrandingService
    {
        if ($getShared) {
            return static::getSharedInstance('branding');
        }

        return new BrandingService();
    }

    public static function seo(bool $getShared = true): SeoService
    {
        if ($getShared) {
            return static::getSharedInstance('seo');
        }

        return new SeoService();
    }

    public static function content(bool $getShared = true): ContentService
    {
        if ($getShared) {
            return static::getSharedInstance('content');
        }

        return new ContentService();
    }

    public static function media(bool $getShared = true): MediaService
    {
        if ($getShared) {
            return static::getSharedInstance('media');
        }

        return new MediaService();
    }

    public static function mailer(bool $getShared = true): MailService
    {
        if ($getShared) {
            return static::getSharedInstance('mailer');
        }

        return new MailService();
    }

    public static function quote(bool $getShared = true): QuoteService
    {
        if ($getShared) {
            return static::getSharedInstance('quote');
        }

        return new QuoteService();
    }

    public static function siteSettings(bool $getShared = true): SiteSettingsService
    {
        if ($getShared) {
            return static::getSharedInstance('siteSettings');
        }

        return new SiteSettingsService();
    }

    public static function seoPresentation(bool $getShared = true): SeoPresentationService
    {
        if ($getShared) {
            return static::getSharedInstance('seoPresentation');
        }

        return new SeoPresentationService();
    }

    public static function schema(bool $getShared = true): SchemaService
    {
        if ($getShared) {
            return static::getSharedInstance('schema');
        }

        return new SchemaService();
    }

    public static function recaptcha(bool $getShared = true): RecaptchaService
    {
        if ($getShared) {
            return static::getSharedInstance('recaptcha');
        }

        return new RecaptchaService();
    }
}
