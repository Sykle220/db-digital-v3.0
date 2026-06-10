<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class AssetsBuild extends BaseCommand
{
    protected $group       = 'Assets';
    protected $name        = 'assets:build';
    protected $description = 'Minifie CSS/JS (npm) et génère assets/build/manifest.json';
    protected $usage       = 'assets:build';

    public function run(array $params)
    {
        $root        = ROOTPATH;
        $packageJson = $root . 'package.json';

        if (! is_file($packageJson)) {
            CLI::error('package.json introuvable à la racine du projet.');

            return EXIT_ERROR;
        }

        $npm = trim((string) shell_exec('command -v npm 2>/dev/null'));
        if ($npm === '') {
            CLI::error('npm n\'est pas installé. Installez Node.js 18+ puis relancez.');

            return EXIT_ERROR;
        }

        CLI::write('Installation des dépendances npm (si nécessaire)…', 'yellow');
        passthru('cd ' . escapeshellarg($root) . ' && (npm ci 2>/dev/null || npm install)', $installCode);

        if ($installCode !== 0) {
            CLI::error('Échec npm install.');

            return EXIT_ERROR;
        }

        CLI::write('Minification des assets…', 'yellow');
        passthru('cd ' . escapeshellarg($root) . ' && npm run build', $buildCode);

        if ($buildCode !== 0) {
            CLI::error('Échec du build assets.');

            return EXIT_ERROR;
        }

        $manifest = $root . 'assets/build/manifest.json';
        if (! is_file($manifest)) {
            CLI::error('manifest.json non généré.');

            return EXIT_ERROR;
        }

        CLI::write('Build terminé : ' . $manifest, 'green');
        CLI::write('En production, activez « Assets minifiés » dans Admin → Intégrations (ou ASSETS_MINIFIED=true).', 'cyan');

        return EXIT_SUCCESS;
    }
}
