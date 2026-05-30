<?php

namespace App\Middlewares;

use Core\Auth;

class GuestMiddleware {
    /**
     * Run the guest check middleware.
     */
    public function handle(): void {
        if (Auth::check()) {
            redirect('/dashboard');
        }
    }
}
