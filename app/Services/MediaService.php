<?php

namespace App\Services;

use App\Models\MediaModel;
use CodeIgniter\HTTP\Files\UploadedFile;

class MediaService
{
    protected MediaModel $mediaModel;
    protected string $uploadRoot;

    /** @var list<string> */
    protected array $allowedMimes = [
        'image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml',
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];

    public function __construct(?MediaModel $mediaModel = null, ?string $uploadRoot = null)
    {
        $this->mediaModel = $mediaModel ?? model(MediaModel::class);
        $this->uploadRoot = $uploadRoot ?? (ROOTPATH . 'uploads');
    }

    /**
     * @return array<string, mixed>|null
     */
    public function upload(UploadedFile $file, string $folder = 'general', ?int $uploadedBy = null): ?array
    {
        if (! $file->isValid()) {
            return null;
        }

        $mimeType     = $file->getMimeType();
        $size         = $file->getSize();
        $originalName = $file->getClientName();

        if (! in_array($mimeType, $this->allowedMimes, true)) {
            return null;
        }

        $targetDir = rtrim($this->uploadRoot, '/') . '/' . trim($folder, '/');
        if (! is_dir($targetDir) && ! mkdir($targetDir, 0755, true) && ! is_dir($targetDir)) {
            return null;
        }

        $newName = $file->getRandomName();
        if (! $file->move($targetDir, $newName)) {
            return null;
        }

        $relativePath = trim($folder, '/') . '/' . $newName;
        $savedPath    = $targetDir . '/' . $newName;
        $width        = null;
        $height       = null;

        if (str_starts_with($mimeType, 'image/') && $mimeType !== 'image/svg+xml') {
            $imageSize = @getimagesize($savedPath);
            if (is_array($imageSize)) {
                $width  = $imageSize[0];
                $height = $imageSize[1];
            }
        }

        $id = $this->mediaModel->insert([
            'filename'      => $relativePath,
            'original_name' => $originalName,
            'mime_type'     => $mimeType,
            'size'          => $size,
            'disk'          => 'local',
            'folder'        => $folder,
            'width'         => $width,
            'height'        => $height,
            'uploaded_by'   => $uploadedBy,
        ], true);

        $record = $this->mediaModel->find($id);
        if (is_array($record)) {
            $record['url'] = $this->getUrlFromRecord($record);
        }

        return is_array($record) ? $record : null;
    }

    public function getUrl(int $mediaId): ?string
    {
        $record = $this->mediaModel->find($mediaId);

        if ($record === null) {
            return null;
        }

        return $this->getUrlFromRecord($record);
    }

    /**
     * @param array<string, mixed> $record
     */
    public function getUrlFromRecord(array $record): string
    {
        $filename = (string) ($record['filename'] ?? '');

        if ($filename === '') {
            return '';
        }

        if (str_starts_with($filename, 'http://') || str_starts_with($filename, 'https://')) {
            return $filename;
        }

        return upload_url($filename);
    }

    public function delete(int $mediaId): bool
    {
        $record = $this->mediaModel->find($mediaId);

        if ($record === null) {
            return false;
        }

        $path = rtrim($this->uploadRoot, '/') . '/' . ltrim((string) $record['filename'], '/');
        if (is_file($path)) {
            @unlink($path);
        }

        return (bool) $this->mediaModel->delete($mediaId);
    }
}
