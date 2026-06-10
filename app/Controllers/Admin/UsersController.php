<?php

namespace App\Controllers\Admin;

use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;

class UsersController extends BaseAdminController
{
    protected string $pageTitle  = 'Utilisateurs';
    protected string $activeMenu = 'users';

    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = auth()->getProvider();
    }

    public function index()
    {
        if (! $this->isSuperAdmin()) {
            return redirect()->to('admin')->with('error', 'Accès réservé aux super-administrateurs.');
        }

        $users = $this->userModel->findAll();

        return $this->render('admin/users/index', ['users' => $users]);
    }

    public function create()
    {
        if (! $this->isSuperAdmin()) {
            return redirect()->to('admin')->with('error', 'Accès réservé aux super-administrateurs.');
        }

        return $this->render('admin/users/form', [
            'user'   => null,
            'action' => site_url('admin/users'),
        ]);
    }

    public function store()
    {
        if (! $this->isSuperAdmin()) {
            return redirect()->to('admin')->with('error', 'Accès réservé aux super-administrateurs.');
        }

        if (! $this->validate([
            'username' => 'required|min_length[3]|max_length[30]|alpha_numeric_punct|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[auth_identities.secret]',
            'password' => 'required|strong_password',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = new User([
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
        ]);

        $this->userModel->save($user);
        $saved = $this->userModel->findById($this->userModel->getInsertID());

        if ($saved !== null) {
            $group = (string) ($this->request->getPost('group') ?? 'admin');
            if (! in_array($group, ['superadmin', 'admin', 'editor', 'developer'], true)) {
                $group = 'admin';
            }
            $saved->addGroup($group);
            $this->userModel->save($saved);
        }

        $this->logActivity('create', 'user', $saved?->id);

        return redirect()->to('admin/users')->with('success', 'Administrateur créé.');
    }

    public function edit(int $id)
    {
        if (! $this->isSuperAdmin()) {
            return redirect()->to('admin')->with('error', 'Accès réservé aux super-administrateurs.');
        }

        $user = $this->userModel->findById($id);
        if ($user === null) {
            return redirect()->to('admin/users')->with('error', 'Utilisateur introuvable.');
        }

        return $this->render('admin/users/form', [
            'user'   => $user,
            'action' => site_url('admin/users/' . $id),
        ]);
    }

    public function update(int $id)
    {
        if (! $this->isSuperAdmin()) {
            return redirect()->to('admin')->with('error', 'Accès réservé aux super-administrateurs.');
        }

        $user = $this->userModel->findById($id);
        if ($user === null) {
            return redirect()->to('admin/users')->with('error', 'Utilisateur introuvable.');
        }

        $rules = [
            'username' => "required|min_length[3]|max_length[30]|alpha_numeric_punct|is_unique[users.username,id,{$id}]",
            'email'    => "required|valid_email|is_unique[auth_identities.secret,user_id,{$id}]",
        ];

        if ($this->request->getPost('password') !== '') {
            $rules['password'] = 'strong_password';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user->username = (string) $this->request->getPost('username');
        $user->email    = (string) $this->request->getPost('email');

        if ($this->request->getPost('password') !== '') {
            $user->password = (string) $this->request->getPost('password');
        }

        $this->userModel->save($user);

        $group = (string) ($this->request->getPost('group') ?? '');
        if (in_array($group, ['superadmin', 'admin', 'editor', 'developer'], true)) {
            $db = $this->userModel->db;
            if ($db->tableExists('auth_groups_users')) {
                $db->table('auth_groups_users')->where('user_id', $id)->delete();
                $db->table('auth_groups_users')->insert(['user_id' => $id, 'group' => $group]);
            }
        }

        $this->logActivity('update', 'user', $id);

        return redirect()->to('admin/users')->with('success', 'Utilisateur mis à jour.');
    }

    public function delete(int $id)
    {
        if (! $this->isSuperAdmin()) {
            return redirect()->to('admin')->with('error', 'Accès réservé aux super-administrateurs.');
        }

        $current = auth()->user();
        if ($current !== null && (int) $current->id === $id) {
            return redirect()->to('admin/users')->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user = $this->userModel->findById($id);
        if ($user === null) {
            return redirect()->to('admin/users')->with('error', 'Utilisateur introuvable.');
        }

        $this->userModel->delete($id, true);
        $this->logActivity('delete', 'user', $id);

        return redirect()->to('admin/users')->with('success', 'Utilisateur supprimé.');
    }

}
