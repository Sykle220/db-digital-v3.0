<?php
require_once __DIR__ . '/includes/functions.php';

header('Content-Type: application/xml; charset=UTF-8');

$base = rtrim((string) SITE_URL, '/');
if ($base === '') {
    // fallback si APP_URL pas configuré
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $base = $scheme . '://' . $host;
}

$pages = [
    ['loc' => '/index.php', 'changefreq' => 'weekly', 'priority' => '1.0'],
    ['loc' => '/services.php', 'changefreq' => 'monthly', 'priority' => '0.9'],
    ['loc' => '/services-details.php?service=digital-strategy', 'changefreq' => 'monthly', 'priority' => '0.8'],
    ['loc' => '/services-details.php?service=web-development', 'changefreq' => 'monthly', 'priority' => '0.8'],
    ['loc' => '/services-details.php?service=branding', 'changefreq' => 'monthly', 'priority' => '0.8'],
    ['loc' => '/services-details.php?service=marketing', 'changefreq' => 'monthly', 'priority' => '0.8'],
    ['loc' => '/projects.php', 'changefreq' => 'monthly', 'priority' => '0.8'],
    ['loc' => '/about.php', 'changefreq' => 'monthly', 'priority' => '0.7'],
    ['loc' => '/blog.php', 'changefreq' => 'weekly', 'priority' => '0.7'],
    ['loc' => '/get-quote.php', 'changefreq' => 'monthly', 'priority' => '0.6'],
];

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

foreach ($pages as $p) {
    foreach (['fr','en'] as $lang) {
        $loc = $base . $p['loc'] . ($lang === 'en' ? '' : '?lang=fr');
        $loc = htmlspecialchars($loc, ENT_QUOTES, 'UTF-8');
        echo "  <url>\n";
        echo "    <loc>{$loc}</loc>\n";
        echo "    <changefreq>{$p['changefreq']}</changefreq>\n";
        echo "    <priority>{$p['priority']}</priority>\n";
        echo "  </url>\n";
    }
}

echo "</urlset>\n";
