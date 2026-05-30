<?php

namespace App\Middlewares;

use Core\Auth;

class AuthMiddleware {
    /**
     * Run the authentication check middleware.
     */
    public function handle(): void {
        if (!Auth::check()) {
            $_SESSION['flash_error'] = 'Silakan masuk terlebih dahulu untuk mengakses halaman ini.';
            redirect('/login');
        }
    }
}
