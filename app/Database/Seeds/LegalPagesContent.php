<?php

namespace App\Database\Seeds;

/**
 * Contenus HTML des pages légales (FR/EN) — cohérents avec la charte DB Digital Agency.
 */
trait LegalPagesContent
{
    /**
     * @return array<string, array{excerpt: string, meta_description: string, content: string}>
     */
    protected function legalPagesDefinitions(): array
    {
        $site  = 'DB Digital Agency';
        $email = 'contact@dbdigitalagency.com';
        $year  = date('Y');

        return [
            'mentions-legales' => [
                'fr' => [
                    'excerpt'          => 'Informations légales relatives à l\'édition et à l\'utilisation du site dbdigitalagency.com.',
                    'meta_description' => 'Mentions légales de DB Digital Agency : éditeur, contact, hébergement, propriété intellectuelle et droit applicable au Cameroun.',
                    'content'          => $this->legalMentionsFr($site, $email, $year),
                ],
                'en' => [
                    'excerpt'          => 'Legal information about the publication and use of dbdigitalagency.com.',
                    'meta_description' => 'DB Digital Agency legal notice: publisher, contact, hosting, intellectual property and applicable law in Cameroon.',
                    'content'          => $this->legalMentionsEn($site, $email, $year),
                ],
            ],
            'politique-confidentialite' => [
                'fr' => [
                    'excerpt'          => 'Comment nous collectons, utilisons et protégeons vos données personnelles.',
                    'meta_description' => 'Politique de confidentialité DB Digital Agency : formulaires, cookies, analytics, vos droits RGPD et contact.',
                    'content'          => $this->legalPrivacyFr($site, $email, $year),
                ],
                'en' => [
                    'excerpt'          => 'How we collect, use and protect your personal data.',
                    'meta_description' => 'DB Digital Agency privacy policy: forms, cookies, analytics, your rights and contact.',
                    'content'          => $this->legalPrivacyEn($site, $email, $year),
                ],
            ],
        ];
    }

    protected function legalMentionsFr(string $site, string $email, string $year): string
    {
        return <<<HTML
<div class="legal-section" id="editeur">
<h2>1. Éditeur du site</h2>
<p>Le site <strong>dbdigitalagency.com</strong> est édité par :</p>
<ul class="legal-list">
<li><strong>Raison sociale :</strong> {$site}</li>
<li><strong>Activité :</strong> Agence digitale — stratégie, design, développement web et marketing d'acquisition</li>
<li><strong>Siège & bureaux :</strong> Douala, Yaoundé et Bafoussam (Cameroun)</li>
<li><strong>Email :</strong> <a href="mailto:{$email}">{$email}</a></li>
<li><strong>Téléphone :</strong> +237 691 323 249</li>
</ul>
</div>

<div class="legal-section" id="publication">
<h2>2. Responsable de la publication</h2>
<p>Le responsable de la publication est la direction de {$site}, joignable à l'adresse <a href="mailto:{$email}">{$email}</a>.</p>
</div>

<div class="legal-section" id="hebergement">
<h2>3. Hébergement</h2>
<p>Le site est hébergé par un prestataire professionnel dont les coordonnées peuvent être communiquées sur demande à <a href="mailto:{$email}">{$email}</a>.</p>
</div>

<div class="legal-section" id="propriete">
<h2>4. Propriété intellectuelle</h2>
<p>L'ensemble des éléments du site (textes, visuels, logos, charte graphique, code, structure) est protégé par le droit de la propriété intellectuelle. Toute reproduction, représentation ou exploitation non autorisée est interdite sans accord écrit préalable de {$site}.</p>
<p>Les marques et logos de tiers mentionnés restent la propriété de leurs titulaires respectifs.</p>
</div>

<div class="legal-section" id="responsabilite">
<h2>5. Limitation de responsabilité</h2>
<p>{$site} s'efforce d'assurer l'exactitude des informations publiées. Toutefois, nous ne saurions être tenus responsables des omissions, inexactitudes ou indisponibilités temporaires du service.</p>
<p>Les liens vers des sites tiers n'engagent pas la responsabilité éditoriale de {$site}.</p>
</div>

<div class="legal-section" id="donnees">
<h2>6. Données personnelles</h2>
<p>Le traitement des données personnelles est décrit dans notre <a href="/fr/politique-confidentialite">politique de confidentialité</a>. Pour toute question : <a href="mailto:{$email}">{$email}</a>.</p>
</div>

<div class="legal-section" id="droit">
<h2>7. Droit applicable</h2>
<p>Les présentes mentions sont régies par le droit en vigueur au Cameroun. En cas de litige, une solution amiable sera recherchée avant toute action judiciaire.</p>
<p class="legal-muted">Dernière mise à jour : {$year}.</p>
</div>
HTML;
    }

    protected function legalMentionsEn(string $site, string $email, string $year): string
    {
        return <<<HTML
<div class="legal-section" id="publisher">
<h2>1. Site publisher</h2>
<p>The website <strong>dbdigitalagency.com</strong> is published by:</p>
<ul class="legal-list">
<li><strong>Company name:</strong> {$site}</li>
<li><strong>Activity:</strong> Digital agency — strategy, design, web development and growth marketing</li>
<li><strong>Offices:</strong> Douala, Yaoundé and Bafoussam (Cameroon)</li>
<li><strong>Email:</strong> <a href="mailto:{$email}">{$email}</a></li>
<li><strong>Phone:</strong> +237 691 323 249</li>
</ul>
</div>

<div class="legal-section" id="publication">
<h2>2. Publication director</h2>
<p>The publication director is the management of {$site}, reachable at <a href="mailto:{$email}">{$email}</a>.</p>
</div>

<div class="legal-section" id="hosting">
<h2>3. Hosting</h2>
<p>The site is hosted by a professional provider; details are available upon request at <a href="mailto:{$email}">{$email}</a>.</p>
</div>

<div class="legal-section" id="ip">
<h2>4. Intellectual property</h2>
<p>All site elements (text, visuals, logos, branding, code, structure) are protected by intellectual property law. Any unauthorized reproduction or use requires prior written consent from {$site}.</p>
<p>Third-party trademarks and logos remain the property of their respective owners.</p>
</div>

<div class="legal-section" id="liability">
<h2>5. Limitation of liability</h2>
<p>{$site} strives to keep published information accurate. We cannot be held liable for omissions, inaccuracies or temporary unavailability.</p>
<p>Links to third-party websites do not imply editorial responsibility by {$site}.</p>
</div>

<div class="legal-section" id="privacy-link">
<h2>6. Personal data</h2>
<p>Personal data processing is described in our <a href="/en/privacy-policy">privacy policy</a>. Questions: <a href="mailto:{$email}">{$email}</a>.</p>
</div>

<div class="legal-section" id="law">
<h2>7. Applicable law</h2>
<p>This legal notice is governed by the laws of Cameroon. Disputes will first be addressed through good-faith negotiation.</p>
<p class="legal-muted">Last updated: {$year}.</p>
</div>
HTML;
    }

    protected function legalPrivacyFr(string $site, string $email, string $year): string
    {
        return <<<HTML
<div class="legal-section" id="responsable">
<h2>1. Responsable du traitement</h2>
<p><strong>{$site}</strong> est responsable du traitement des données collectées via ce site. Contact : <a href="mailto:{$email}">{$email}</a>.</p>
</div>

<div class="legal-section" id="donnees-collectees">
<h2>2. Données collectées</h2>
<p>Selon vos interactions, nous pouvons traiter :</p>
<ul class="legal-list">
<li><strong>Formulaire de contact</strong> — nom, téléphone, email, message</li>
<li><strong>Demande de devis</strong> — coordonnées, détails du projet, pièces jointes éventuelles</li>
<li><strong>Newsletter</strong> — adresse email</li>
<li><strong>Espace devis client</strong> — email et données liées à votre demande</li>
<li><strong>Données techniques</strong> — logs, adresse IP, navigateur (sécurité et statistiques)</li>
</ul>
</div>

<div class="legal-section" id="finalites">
<h2>3. Finalités</h2>
<ul class="legal-list">
<li>Répondre à vos demandes et assurer le suivi commercial</li>
<li>Envoyer la newsletter (avec votre consentement)</li>
<li>Améliorer le site, mesurer l'audience et prévenir les abus</li>
<li>Respecter nos obligations légales</li>
</ul>
</div>

<div class="legal-section" id="base-legale">
<h2>4. Base légale</h2>
<p>Les traitements reposent sur l'exécution de mesures précontractuelles, votre consentement (newsletter, cookies non essentiels), notre intérêt légitime (sécurité, amélioration du service) ou une obligation légale.</p>
</div>

<div class="legal-section" id="conservation">
<h2>5. Durée de conservation</h2>
<p>Les données de contact et devis sont conservées pendant la durée de la relation commerciale, puis archivées selon les délais légaux applicables. Les abonnés newsletter sont conservés jusqu'à désinscription.</p>
</div>

<div class="legal-section" id="cookies">
<h2>6. Cookies & mesure d'audience</h2>
<p>Des cookies peuvent être déposés après votre consentement via le bandeau cookies :</p>
<ul class="legal-list">
<li>Mesure d'audience (ex. Google Analytics 4, Microsoft Clarity, Hotjar)</li>
<li>Outils marketing (ex. Meta Pixel, LinkedIn Insight Tag)</li>
<li>Google Tag Manager pour la gestion des balises</li>
</ul>
<p>Vous pouvez refuser les cookies non essentiels ou retirer votre consentement à tout moment via les paramètres de votre navigateur.</p>
</div>

<div class="legal-section" id="securite">
<h2>7. Sécurité</h2>
<p>Nous mettons en œuvre des mesures techniques et organisationnelles : chiffrement HTTPS, limitation du débit sur les formulaires, reCAPTCHA v3, honeypot anti-spam et accès restreint aux données.</p>
</div>

<div class="legal-section" id="droits">
<h2>8. Vos droits</h2>
<p>Vous disposez d'un droit d'accès, de rectification, d'effacement, de limitation, d'opposition et de portabilité lorsque applicable. Pour exercer vos droits : <a href="mailto:{$email}">{$email}</a>.</p>
</div>

<div class="legal-section" id="transferts">
<h2>9. Transferts & sous-traitants</h2>
<p>Certains outils (hébergement, email, analytics) peuvent impliquer des sous-traitants situés hors du Cameroun, avec des garanties appropriées lorsque requis.</p>
</div>

<div class="legal-section" id="mentions">
<h2>10. Mentions légales</h2>
<p>Consultez également nos <a href="/fr/mentions-legales">mentions légales</a>.</p>
<p class="legal-muted">Dernière mise à jour : {$year}.</p>
</div>
HTML;
    }

    protected function legalPrivacyEn(string $site, string $email, string $year): string
    {
        return <<<HTML
<div class="legal-section" id="controller">
<h2>1. Data controller</h2>
<p><strong>{$site}</strong> is the data controller for information collected through this website. Contact: <a href="mailto:{$email}">{$email}</a>.</p>
</div>

<div class="legal-section" id="data-collected">
<h2>2. Data we collect</h2>
<p>Depending on your interactions, we may process:</p>
<ul class="legal-list">
<li><strong>Contact form</strong> — name, phone, email, message</li>
<li><strong>Quote request</strong> — contact details, project details, optional attachments</li>
<li><strong>Newsletter</strong> — email address</li>
<li><strong>Client quote portal</strong> — email and data related to your request</li>
<li><strong>Technical data</strong> — logs, IP address, browser (security and analytics)</li>
</ul>
</div>

<div class="legal-section" id="purposes">
<h2>3. Purposes</h2>
<ul class="legal-list">
<li>Respond to inquiries and manage commercial follow-up</li>
<li>Send the newsletter (with your consent)</li>
<li>Improve the site, measure traffic and prevent abuse</li>
<li>Comply with legal obligations</li>
</ul>
</div>

<div class="legal-section" id="legal-basis">
<h2>4. Legal basis</h2>
<p>Processing is based on pre-contractual steps, your consent (newsletter, non-essential cookies), our legitimate interest (security, service improvement) or legal obligation.</p>
</div>

<div class="legal-section" id="retention">
<h2>5. Retention</h2>
<p>Contact and quote data are kept for the business relationship duration, then archived per applicable legal periods. Newsletter subscribers are kept until unsubscribe.</p>
</div>

<div class="legal-section" id="cookies">
<h2>6. Cookies & analytics</h2>
<p>Cookies may be set after consent via our cookie banner:</p>
<ul class="legal-list">
<li>Audience measurement (e.g. Google Analytics 4, Microsoft Clarity, Hotjar)</li>
<li>Marketing tools (e.g. Meta Pixel, LinkedIn Insight Tag)</li>
<li>Google Tag Manager for tag management</li>
</ul>
<p>You may refuse non-essential cookies or withdraw consent via your browser settings.</p>
</div>

<div class="legal-section" id="security">
<h2>7. Security</h2>
<p>We apply technical and organizational measures: HTTPS encryption, form rate limiting, reCAPTCHA v3, anti-spam honeypot and restricted data access.</p>
</div>

<div class="legal-section" id="rights">
<h2>8. Your rights</h2>
<p>You may request access, rectification, erasure, restriction, objection and portability where applicable. Contact: <a href="mailto:{$email}">{$email}</a>.</p>
</div>

<div class="legal-section" id="processors">
<h2>9. Processors & transfers</h2>
<p>Some tools (hosting, email, analytics) may involve processors outside Cameroon, with appropriate safeguards when required.</p>
</div>

<div class="legal-section" id="legal-notice">
<h2>10. Legal notice</h2>
<p>See also our <a href="/en/legal-notice">legal notice</a>.</p>
<p class="legal-muted">Last updated: {$year}.</p>
</div>
HTML;
    }
}
