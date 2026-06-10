<?php

namespace App\Services;

/**
 * Générateurs JSON-LD Schema.org pour le front.
 */
class SchemaService
{
    /**
     * @param array<string, mixed> $site
     */
    public function organization(array $site): array
    {
        return [
            '@context'    => 'https://schema.org',
            '@type'       => 'Organization',
            'name'        => (string) ($site['name'] ?? 'DB Digital Agency'),
            'url'         => rtrim(base_url(), '/'),
            'email'       => (string) ($site['email'] ?? ''),
            'telephone'   => (string) ($site['phone'] ?? ''),
            'address'     => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => (string) ($site['address'] ?? ''),
                'addressCountry'  => 'CM',
            ],
        ];
    }

    /**
     * @param list<array{label: string, url?: string}> $items
     */
    public function breadcrumbList(array $items): array
    {
        $list = [];
        foreach ($items as $i => $item) {
            $entry = [
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'name'     => (string) ($item['label'] ?? ''),
            ];
            if (! empty($item['url'])) {
                $entry['item'] = (string) $item['url'];
            }
            $list[] = $entry;
        }

        return [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $list,
        ];
    }

    /**
     * @param list<array{question: string, answer: string}> $faqs
     */
    public function faqPage(array $faqs): array
    {
        $entities = [];
        foreach ($faqs as $faq) {
            $q = trim((string) ($faq['question'] ?? ''));
            $a = trim((string) ($faq['answer'] ?? ''));
            if ($q === '' || $a === '') {
                continue;
            }
            $entities[] = [
                '@type'          => 'Question',
                'name'           => $q,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text'  => $a,
                ],
            ];
        }

        return [
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => $entities,
        ];
    }

    /**
     * @param array<string, mixed> $post
     */
    public function article(array $post, string $locale): array
    {
        $url = $post['url'] ?? current_url();
        $image = (string) ($post['image_url'] ?? $post['image'] ?? '');
        if ($image !== '' && ! str_starts_with($image, 'http')) {
            $image = asset_url('img/blog/' . ltrim($image, '/'));
        }

        $schema = [
            '@context'      => 'https://schema.org',
            '@type'         => 'Article',
            'headline'      => (string) ($post['title'] ?? ''),
            'description'   => (string) ($post['excerpt'] ?? ''),
            'datePublished' => (string) ($post['published_at'] ?? $post['created_at'] ?? ''),
            'dateModified'  => (string) ($post['updated_at'] ?? $post['published_at'] ?? ''),
            'author'        => [
                '@type' => 'Organization',
                'name'  => (string) ($post['author'] ?? 'DB Digital Agency'),
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name'  => 'DB Digital Agency',
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id'   => $url,
            ],
            'inLanguage' => $locale === 'fr' ? 'fr-FR' : 'en-US',
        ];

        if ($image !== '') {
            $schema['image'] = [$image];
        }

        return $schema;
    }

    /**
     * @param array<string, mixed> $office
     */
    public function localBusiness(array $office, string $locale, string $siteName): array
    {
        $city = (string) ($office['city'] ?? $office['translation']['city'] ?? '');
        $address = (string) ($office['address'] ?? $office['translation']['address'] ?? '');
        $phone = (string) ($office['phone'] ?? '');
        $email = (string) ($office['email'] ?? '');
        $lat   = (float) ($office['lat'] ?? 0);
        $lng   = (float) ($office['lng'] ?? 0);

        $schema = [
            '@context'    => 'https://schema.org',
            '@type'       => 'LocalBusiness',
            'name'        => $siteName . ($city !== '' ? ' — ' . $city : ''),
            'description' => $locale === 'fr'
                ? 'Agence digitale à ' . $city . ' — stratégie, web, branding et croissance.'
                : 'Digital agency in ' . $city . ' — strategy, web, branding and growth.',
            'url'         => rtrim(base_url(), '/'),
            'email'       => $email,
            'telephone'   => $phone,
            'address'     => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => $address,
                'addressLocality' => $city,
                'addressCountry'  => 'CM',
            ],
        ];

        if ($lat !== 0.0 || $lng !== 0.0) {
            $schema['geo'] = [
                '@type'     => 'GeoCoordinates',
                'latitude'  => $lat,
                'longitude' => $lng,
            ];
        }

        return $schema;
    }
}
