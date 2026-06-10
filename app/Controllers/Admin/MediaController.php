<?php

namespace App\Controllers\Admin;

use App\Models\MediaModel;
use App\Services\MediaService;

class MediaController extends BaseAdminController
{
    protected string $pageTitle  = 'Médias';
    protected string $activeMenu = 'media';

    protected MediaModel $mediaModel;
    protected MediaService $mediaService;

    public function __construct()
    {
        $this->mediaModel   = model(MediaModel::class);
        $this->mediaService = service('media');
    }

    public function index()
    {
        $folder  = (string) ($this->request->getGet('folder') ?? '');
        $perPage = 24;
        $builder = $this->mediaModel->orderBy('created_at', 'DESC');

        if ($folder !== '') {
            $builder->where('folder', $folder);
        }

        $media = $builder->paginate($perPage);
        foreach ($media as &$item) {
            $item['url'] = $this->mediaService->getUrlFromRecord($item);
        }
        unset($item);

        $folders = $this->mediaModel->db->table('media')
            ->select('folder')
            ->distinct()
            ->orderBy('folder', 'ASC')
            ->get()
            ->getResultArray();

        $pagerService = $this->mediaModel->pager;

        return $this->render('admin/media/index', [
            'media'       => $media,
            'pager'       => $this->pagerRenderer(),
            'folder'      => $folder,
            'folders'     => array_column($folders, 'folder'),
            'totalMedia'  => $pagerService->getTotal(),
            'perPage'     => $perPage,
        ]);
    }

    public function store()
    {
        $file = $this->request->getFile('file');
        if ($file === null || ! $file->isValid()) {
            return redirect()->back()->with('error', 'Fichier invalide.');
        }

        $folder = (string) ($this->request->getPost('folder') ?? 'general');
        $upload = $this->mediaService->upload($file, $folder, auth()->id());

        if ($upload === null) {
            return redirect()->back()->with('error', 'Échec du téléversement.');
        }

        $this->logActivity('upload', 'media', (int) $upload['id'], $upload['original_name'] ?? null);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true, 'media' => $upload]);
        }

        $redirectFolder = (string) ($this->request->getPost('redirect_folder') ?? $folder);

        return redirect()->to($this->mediaIndexUrl($redirectFolder))->with('success', 'Fichier téléversé.');
    }

    public function delete(int $id)
    {
        if (! $this->mediaService->delete($id)) {
            return redirect()->back()->with('error', 'Média introuvable.');
        }

        $this->logActivity('delete', 'media', $id);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true]);
        }

        return redirect()->back()->with('success', 'Média supprimé.');
    }

    public function picker()
    {
        $type = (string) ($this->request->getGet('type') ?? 'image');
        $builder = $this->mediaModel->orderBy('created_at', 'DESC')->limit(50);

        if ($type === 'image') {
            $builder->like('mime_type', 'image/', 'after');
        }

        $items = $builder->findAll();
        foreach ($items as &$item) {
            $item['url'] = $this->mediaService->getUrlFromRecord($item);
        }
        unset($item);

        return $this->response->setJSON(['items' => $items]);
    }

    protected function mediaIndexUrl(string $folder = ''): string
    {
        $url = site_url('admin/media');

        return $folder !== '' ? $url . '?folder=' . rawurlencode($folder) : $url;
    }
}
