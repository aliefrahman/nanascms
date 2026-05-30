<?php

namespace App\Middlewares;

use Core\Auth;

class AdminOrEditorMiddleware {
    /**
     * Run the Admin or Editor role check middleware.
     */
    public function handle(): void {
        // Enforce active session
        if (!Auth::check()) {
            $_SESSION['flash_error'] = 'Silakan masuk terlebih dahulu untuk mengakses halaman ini.';
            redirect('/login');
        }

        // Enforce Admin or Editor role restriction
        $role = Auth::role();
        if ($role !== 'Admin' && $role !== 'Editor') {
            $_SESSION['flash_error'] = 'Anda tidak memiliki hak akses untuk halaman tersebut.';
            redirect('/dashboard');
        }
    }
}
