<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MediaSeeder extends Seeder
{
    /** @var array<string, list<string>> */
    protected array $folders = [
        'branding' => ['logo', 'favicon.png'],
        'brand'    => ['brand'],
        'team'     => ['team'],
        'images'   => ['images'],
        'blog'     => ['blog'],
        'services' => ['services'],
        'projects' => ['project'],
    ];

    public function run(): void
    {
        if (! $this->db->tableExists('media')) {
            return;
        }

        $assetsRoot = rtrim(FCPATH, '/') . '/assets/img';

        $this->importFile($assetsRoot . '/favicon.png', 'branding');

        foreach ($this->folders as $folder => $subdirs) {
            foreach ($subdirs as $subdir) {
                $path = $assetsRoot . '/' . $subdir;
                if (! is_dir($path)) {
                    continue;
                }

                $limit = match ($folder) {
                    'images'   => 40,
                    'services' => 20,
                    'projects' => 15,
                    'blog'     => 20,
                    default    => 50,
                };

                $this->importDirectory($path, $folder, $limit);
            }
        }
    }

    protected function importDirectory(string $directory, string $folder, int $limit = 50): void
    {
        $files = glob($directory . '/*.{png,jpg,jpeg,gif,webp,svg}', GLOB_BRACE) ?: [];
        sort($files);

        foreach (array_slice($files, 0, $limit) as $file) {
            $this->importFile($file, $folder);
        }
    }

    protected function importFile(string $sourcePath, string $folder): ?int
    {
        if (! is_file($sourcePath)) {
            return null;
        }

        $basename = basename($sourcePath);

        $existing = $this->db->table('media')
            ->where('folder', $folder)
            ->where('original_name', $basename)
            ->get()
            ->getRowArray();

        if ($existing) {
            return (int) $existing['id'];
        }

        $targetDir = ROOTPATH . 'uploads/' . $folder;
        if (! is_dir($targetDir) && ! mkdir($targetDir, 0755, true) && ! is_dir($targetDir)) {
            return null;
        }

        $targetPath = $targetDir . '/' . $basename;
        if (! is_file($targetPath) && ! copy($sourcePath, $targetPath)) {
            return null;
        }

        $mime = mime_content_type($targetPath) ?: 'application/octet-stream';
        $size = filesize($targetPath) ?: 0;
        $width = null;
        $height = null;

        if (str_starts_with($mime, 'image/') && $mime !== 'image/svg+xml') {
            $dimensions = @getimagesize($targetPath);
            if (is_array($dimensions)) {
                $width  = $dimensions[0];
                $height = $dimensions[1];
            }
        }

        $this->db->table('media')->insert([
            'filename'      => $folder . '/' . $basename,
            'original_name' => $basename,
            'mime_type'     => $mime,
            'size'          => $size,
            'disk'          => 'local',
            'folder'        => $folder,
            'width'         => $width,
            'height'        => $height,
            'uploaded_by'   => null,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);

        return (int) $this->db->insertID();
    }
}
