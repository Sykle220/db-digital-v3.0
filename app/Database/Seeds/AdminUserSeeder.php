<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email    = (string) env('ADMIN_SEED_EMAIL', env('ADMIN_EMAIL', 'admin@dbdigitalagency.com'));
        $password = (string) env('ADMIN_SEED_PASSWORD', 'ChangeMe123!');

        if ($email === '' || $password === '') {
            return;
        }

        $users = auth()->getProvider();
        $existing = $users->findByCredentials(['email' => $email]);

        if ($existing !== null) {
            if (! $existing->inGroup('superadmin')) {
                $existing->addGroup('superadmin');
                $users->save($existing);
            }

            return;
        }

        $username = strstr($email, '@', true) ?: 'admin';

        $user = new User([
            'username' => $username,
            'email'    => $email,
            'password' => $password,
        ]);

        $users->save($user);
        $user = $users->findById($users->getInsertID());

        if ($user !== null) {
            $user->addGroup('superadmin');
            $users->save($user);
        }
    }
}
