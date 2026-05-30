<?php

namespace App\Controllers;

use Core\Controller;
use Core\Database;
use Core\Auth;
use App\Models\User;
use App\Models\Setting;

class AuthController extends Controller
{
    /**
     * Display the login form.
     */
    public function showLoginForm(): void
    {
        $this->view('auth/login', [
            'companyName' => Setting::get('company_name'),
            'tagline' => 'Masuk ke Dashboard'
        ]);
    }

    /**
     * Process authentication login request.
     */
    public function login(): void
    {
        $loginInput = trim($_POST['login'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($loginInput) || empty($password)) {
            $_SESSION['flash_error'] = 'Silakan masukkan username/email dan password Anda.';
            redirect('/login');
        }

        // Query user by username or email using the User Model
        $user = User::findByUsernameOrEmail($loginInput);

        if ($user && password_verify($password, $user['password_hash'])) {
            Auth::login($user['id']);
            redirect('/dashboard');
        } else {
            $_SESSION['flash_error'] = 'Username, email, atau password salah.';
            redirect('/login');
        }
    }

    /**
     * Display the registration form.
     */
    public function showRegisterForm(): void
    {
        // Fetch available roles dynamically from the database
        $roles = Database::query("SELECT id, name FROM roles ORDER BY id ASC")->fetchAll();

        $this->view('auth/register', [
            'companyName' => 'Nanas Home Studio',
            'tagline' => 'Buat Akun Baru',
            'roles' => $roles
        ]);
    }

    /**
     * Process registration request.
     */
    public function register(): void
    {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $roleId = (int) ($_POST['role_id'] ?? 0);

        if (empty($username) || empty($email) || empty($password) || empty($roleId)) {
            $_SESSION['flash_error'] = 'Semua field wajib diisi.';
            redirect('/register');
        }

        // Validate username length
        if (strlen($username) < 3) {
            $_SESSION['flash_error'] = 'Username minimal 3 karakter.';
            redirect('/register');
        }

        // Verify if username already exists using the User Model
        if (User::existsUsername($username)) {
            $_SESSION['flash_error'] = 'Username sudah digunakan.';
            redirect('/register');
        }

        // Verify if email already exists using the User Model
        if (User::existsEmail($email)) {
            $_SESSION['flash_error'] = 'Email sudah terdaftar.';
            redirect('/register');
        }

        // Hash password securely using bcrypt
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        try {
            User::create([
                'username' => $username,
                'email' => $email,
                'password_hash' => $passwordHash,
                'role_id' => $roleId
            ]);

            $_SESSION['flash_success'] = 'Registrasi berhasil! Silakan masuk dengan akun baru Anda.';
            redirect('/login');
        } catch (\PDOException $e) {
            $_SESSION['flash_error'] = 'Gagal menyimpan data user: ' . $e->getMessage();
            redirect('/register');
        }
    }

    /**
     * Process logout request.
     */
    public function logout(): void
    {
        Auth::logout();
        $_SESSION['flash_success'] = 'Anda telah berhasil keluar.';
        redirect('/login');
    }
}
