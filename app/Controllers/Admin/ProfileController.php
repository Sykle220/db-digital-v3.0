<?php

namespace App\Controllers\Admin;

use CodeIgniter\Shield\Entities\User;

class ProfileController extends BaseAdminController
{
    protected string $pageTitle  = 'Mon profil';
    protected string $activeMenu = 'profile';

    public function index()
    {
        return $this->render('admin/profile/index', [
            'user'           => auth()->user(),
            'profileAction'  => site_url('admin/profile'),
            'passwordAction' => site_url('admin/profile/password'),
        ]);
    }

    public function update()
    {
        /** @var User|null $user */
        $user = auth()->user();
        if ($user === null) {
            return redirect()->to('login');
        }

        if (! $this->validate([
            'username' => "required|min_length[3]|max_length[30]|alpha_numeric_punct|is_unique[users.username,id,{$user->id}]",
            'email'    => "required|valid_email|is_unique[auth_identities.secret,user_id,{$user->id}]",
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $users = auth()->getProvider();
        $user->fill([
            'username' => $this->request->getPost('username'),
        ]);
        $users->save($user);

        $identity = $user->getEmailIdentity();
        if ($identity !== null) {
            $identity->secret = $this->request->getPost('email');
            $users->save($identity);
        }

        $this->logActivity('update', 'profile', (int) $user->id);

        return redirect()->to('admin/profile')->with('success', 'Profil mis à jour.');
    }

    public function changePassword()
    {
        /** @var User|null $user */
        $user = auth()->user();
        if ($user === null) {
            return redirect()->to('login');
        }

        $rules = [
            'password'     => 'required|strong_password',
            'pass_confirm' => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user->password = $this->request->getPost('password');
        auth()->getProvider()->save($user);

        $this->logActivity('change_password', 'profile', (int) $user->id);

        return redirect()->to('admin/profile')->with('success', 'Mot de passe modifié.');
    }
}
