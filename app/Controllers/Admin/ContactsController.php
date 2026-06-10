<?php

namespace App\Controllers\Admin;

use App\Models\ContactMessageModel;

class ContactsController extends BaseAdminController
{
    protected string $pageTitle  = 'Contacts';
    protected string $activeMenu = 'contacts';

    protected ContactMessageModel $model;

    public function __construct()
    {
        $this->model = model(ContactMessageModel::class);
    }

    public function index()
    {
        $status = (string) ($this->request->getGet('status') ?? '');
        $builder = $this->model->orderBy('created_at', 'DESC');

        if ($status !== '') {
            $builder->where('status', $status);
        }

        return $this->render('admin/contacts/index', [
            'contacts' => $builder->paginate(20),
            'pager'    => $this->model->pager,
            'status'   => $status,
        ]);
    }

    public function show(int $id)
    {
        $contact = $this->model->find($id);
        if ($contact === null) {
            return redirect()->to('admin/contacts')->with('error', 'Message introuvable.');
        }

        if ($contact['status'] === 'new') {
            $this->model->update($id, ['status' => 'read']);
            $contact['status'] = 'read';
        }

        return $this->render('admin/contacts/show', ['contact' => $contact]);
    }

    public function update(int $id)
    {
        $contact = $this->model->find($id);
        if ($contact === null) {
            return redirect()->to('admin/contacts')->with('error', 'Message introuvable.');
        }

        $status = (string) $this->request->getPost('status');
        $allowed = ['new', 'read', 'replied', 'archived'];

        if (! in_array($status, $allowed, true)) {
            return redirect()->back()->with('error', 'Statut invalide.');
        }

        $this->model->update($id, ['status' => $status]);
        $this->logActivity('update', 'contact', $id, $status);

        return redirect()->to('admin/contacts/' . $id)->with('success', 'Statut mis à jour.');
    }
}
