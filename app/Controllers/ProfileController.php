<?php

namespace App\Controllers;

use Core\Controller;
use Core\Auth;
use App\Models\User;
use App\Models\Setting;

class ProfileController extends Controller
{
    /**
     * Display current user profile edit form.
     */
    public function index(): void
    {
        $currentUser = Auth::user();

        $this->view('profile/index', [
            'companyName' => Setting::get('company_name'),
            'tagline' => 'Pengaturan Profil',
            'user' => $currentUser
        ]);
    }

    /**
     * Process profile update request.
     */
    public function update(): void
    {
        $currentUser = Auth::user();
        $id = (int) $currentUser['id'];

        $username = trim($_POST['username'] ?? '');
        $fullname = trim($_POST['fullname'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $avatar = trim($_POST['avatar'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($email)) {
            $_SESSION['flash_error'] = 'Username dan email wajib diisi.';
            redirect('/profile');
        }

        if (strlen($username) < 3) {
            $_SESSION['flash_error'] = 'Username minimal 3 karakter.';
            redirect('/profile');
        }

        // Validate unique username (excluding current user)
        if (User::existsUsername($username, $id)) {
            $_SESSION['flash_error'] = 'Username sudah digunakan oleh user lain.';
            redirect('/profile');
        }

        // Validate unique email (excluding current user)
        if (User::existsEmail($email, $id)) {
            $_SESSION['flash_error'] = 'Email sudah terdaftar oleh user lain.';
            redirect('/profile');
        }

        try {
            $data = [
                'username' => $username,
                'fullname' => $fullname ?: null,
                'email' => $email,
                'avatar' => $avatar ?: null,
                'role_id' => (int) $currentUser['role_id'] // Keep existing role
            ];

            if (!empty($password)) {
                if (strlen($password) < 6) {
                    $_SESSION['flash_error'] = 'Password baru minimal 6 karakter.';
                    redirect('/profile');
                }
                $data['password_hash'] = password_hash($password, PASSWORD_BCRYPT);
            }

            User::update($id, $data);

            $_SESSION['flash_success'] = 'Profil Anda berhasil diperbarui!';
            redirect('/profile');
        } catch (\PDOException $e) {
            $_SESSION['flash_error'] = 'Gagal memperbarui profil: ' . $e->getMessage();
            redirect('/profile');
        }
    }
}
