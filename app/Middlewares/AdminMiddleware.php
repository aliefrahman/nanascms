<?php

namespace App\Middlewares;

use Core\Auth;

class AdminMiddleware {
    /**
     * Run the Admin role check middleware.
     */
    public function handle(): void {
        // Enforce active session
        if (!Auth::check()) {
            $_SESSION['flash_error'] = 'Silakan masuk terlebih dahulu untuk mengakses halaman ini.';
            redirect('/login');
        }

        // Enforce Admin role restriction
        if (Auth::role() !== 'Admin') {
            $_SESSION['flash_error'] = 'Anda tidak memiliki hak akses untuk halaman tersebut.';
            redirect('/dashboard');
        }
    }
}
