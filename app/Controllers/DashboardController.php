<?php

namespace App\Controllers;

use Core\Controller;
use Core\Auth;
use App\Models\Setting;

class DashboardController extends Controller
{
    /**
     * Render the admin/user dashboard control panel.
     */
    public function index(): void
    {
        // Get the current user
        $currentUser = Auth::user();

        // Prepare dashboard data
        $data = [
            'companyName' => Setting::get('company_name'),
            'tagline' => 'Dashboard',
            'user' => $currentUser,
            'allUsers' => []
        ];

        // If the user has Admin role, pull other users and role names
        if ($currentUser['role_name'] === 'Admin') {
            try {
                $data['allUsers'] = \App\Models\User::all();
            } catch (\PDOException $e) {
                // Fail silently or pass warning
                $data['db_warning'] = 'Gagal mengambil data user: ' . $e->getMessage();
            }
        }

        $this->view('dashboard/index', $data);
    }
}
