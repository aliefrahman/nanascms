<?php

namespace App\Controllers;

use Core\Controller;
use Core\Database;
use Core\Auth;
use App\Models\User;
use App\Models\Setting;

class UserController extends Controller
{
    /**
     * Display list of users.
     */
    public function index(): void
    {
        try {
            $users = User::all();
        } catch (\PDOException $e) {
            $users = [];
            $_SESSION['flash_error'] = 'Gagal mengambil data user: ' . $e->getMessage();
        }

        $this->view('users/index', [
            'companyName' => Setting::get('company_name'),
            'tagline' => 'Kelola Pengguna',
            'users' => $users
        ]);
    }

    /**
     * Display form to create a new user.
     */
    public function create(): void
    {
        try {
            $roles = Database::query("SELECT id, name FROM roles ORDER BY id ASC")->fetchAll();
        } catch (\PDOException $e) {
            $roles = [];
            $_SESSION['flash_error'] = 'Gagal mengambil data roles: ' . $e->getMessage();
        }

        $this->view('users/create', [
            'companyName' => 'Nanas Home Studio',
            'tagline' => 'Tambah User Baru',
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created user.
     */
    public function store(): void
    {
        $username = trim($_POST['username'] ?? '');
        $fullname = trim($_POST['fullname'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $avatar = trim($_POST['avatar'] ?? '');
        $password = $_POST['password'] ?? '';
        $roleId = (int) ($_POST['role_id'] ?? 0);

        if (empty($username) || empty($email) || empty($password) || empty($roleId)) {
            $_SESSION['flash_error'] = 'Username, email, password, dan role wajib diisi.';
            redirect('/users/create');
        }

        if (strlen($username) < 3) {
            $_SESSION['flash_error'] = 'Username minimal 3 karakter.';
            redirect('/users/create');
        }

        // Check unique username
        if (User::existsUsername($username)) {
            $_SESSION['flash_error'] = 'Username sudah digunakan.';
            redirect('/users/create');
        }

        // Check unique email
        if (User::existsEmail($email)) {
            $_SESSION['flash_error'] = 'Email sudah terdaftar.';
            redirect('/users/create');
        }

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        try {
            User::create([
                'username' => $username,
                'fullname' => $fullname ?: null,
                'email' => $email,
                'avatar' => $avatar ?: null,
                'password_hash' => $passwordHash,
                'role_id' => $roleId
            ]);

            $_SESSION['flash_success'] = 'User baru berhasil ditambahkan!';
            redirect('/users');
        } catch (\PDOException $e) {
            $_SESSION['flash_error'] = 'Gagal menambahkan user: ' . $e->getMessage();
            redirect('/users/create');
        }
    }

    /**
     * Display edit form for a user.
     */
    public function edit(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {
            $_SESSION['flash_error'] = 'ID user tidak valid.';
            redirect('/users');
        }

        try {
            $user = User::find($id);
            $roles = Database::query("SELECT id, name FROM roles ORDER BY id ASC")->fetchAll();
        } catch (\PDOException $e) {
            $_SESSION['flash_error'] = 'Kesalahan database: ' . $e->getMessage();
            redirect('/users');
        }

        if (!$user) {
            $_SESSION['flash_error'] = 'User tidak ditemukan.';
            redirect('/users');
        }

        $this->view('users/edit', [
            'companyName' => 'Nanas Home Studio',
            'tagline' => 'Edit Pengguna',
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Update user details.
     */
    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $username = trim($_POST['username'] ?? '');
        $fullname = trim($_POST['fullname'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $avatar = trim($_POST['avatar'] ?? '');
        $password = $_POST['password'] ?? '';
        $roleId = (int) ($_POST['role_id'] ?? 0);

        if ($id <= 0 || empty($username) || empty($email) || empty($roleId)) {
            $_SESSION['flash_error'] = 'Username, email, dan role wajib diisi.';
            redirect('/users/edit?id=' . $id);
        }

        // Validate unique username (excluding current user)
        if (User::existsUsername($username, $id)) {
            $_SESSION['flash_error'] = 'Username sudah digunakan.';
            redirect('/users/edit?id=' . $id);
        }

        // Validate unique email (excluding current user)
        if (User::existsEmail($email, $id)) {
            $_SESSION['flash_error'] = 'Email sudah terdaftar.';
            redirect('/users/edit?id=' . $id);
        }

        try {
            $data = [
                'username' => $username,
                'fullname' => $fullname ?: null,
                'email' => $email,
                'avatar' => $avatar ?: null,
                'role_id' => $roleId
            ];
            if (!empty($password)) {
                $data['password_hash'] = password_hash($password, PASSWORD_BCRYPT);
            }

            User::update($id, $data);

            $_SESSION['flash_success'] = 'Data user berhasil diperbarui!';
            redirect('/users');
        } catch (\PDOException $e) {
            $_SESSION['flash_error'] = 'Gagal memperbarui user: ' . $e->getMessage();
            redirect('/users/edit?id=' . $id);
        }
    }

    /**
     * Delete user from system.
     */
    public function delete(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        $currentUser = Auth::user();

        if ($id <= 0) {
            $_SESSION['flash_error'] = 'ID user tidak valid.';
            redirect('/users');
        }

        // Prevent self-deletion
        if ($id === (int) $currentUser['id']) {
            $_SESSION['flash_error'] = 'Anda tidak dapat menghapus akun Anda sendiri.';
            redirect('/users');
        }

        try {
            User::delete($id);
            $_SESSION['flash_success'] = 'User berhasil dihapus!';
            redirect('/users');
        } catch (\PDOException $e) {
            $_SESSION['flash_error'] = 'Gagal menghapus user: ' . $e->getMessage();
            redirect('/users');
        }
    }
}
