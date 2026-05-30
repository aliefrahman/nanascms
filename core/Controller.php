<?php

namespace Core;

use App\Models\Setting;
use Core\Config;

class Controller
{
    /**
     * Render view file
     *
     * @param string $name Name of the view file (e.g. 'home' or 'layout/main')
     * @param array $data Data array to extract and make available to the view
     */
    protected function view(string $name, array $data = []): void
    {
        // Ambil data pengaturan secara global
        $settings = Setting::getSettings() ?? [];

        // Ambil data menu secara global, tangani jika tabel menus belum ada
        $globalMenus = [];
        try {
            $globalMenus = \App\Models\Menu::all();
        } catch (\PDOException $e) {
            // Jika tabel menus belum dibuat, abaikan error agar halaman tidak crash
        }

        // Inject variabel pengaturan ke view jika belum di-set secara eksplisit di array $data
        $data['appBaseUrl'] = $data['appBaseUrl'] ?? Config::get('app.base_url');
        $data['appName'] = $data['appName'] ?? Config::get('app.name');
        $data['globalMenus'] = $data['globalMenus'] ?? $globalMenus;
        $data['companyName'] = $data['companyName'] ?? ($settings['company_name'] ?? null);
        $data['brandName'] = $data['brandName'] ?? ($settings['brand_name'] ?? null);
        $data['tagline'] = $data['tagline'] ?? ($settings['tagline'] ?? null);
        $data['description'] = $data['description'] ?? ($settings['description'] ?? null);
        $data['address'] = $data['address'] ?? ($settings['address'] ?? null);
        $data['contactNumber'] = $data['contactNumber'] ?? ($settings['contact_number'] ?? null);
        $data['companyEmail'] = $data['companyEmail'] ?? ($settings['company_email'] ?? null);
        $data['latitude'] = $data['latitude'] ?? ($settings['latitude'] ?? null);
        $data['longitude'] = $data['longitude'] ?? ($settings['longitude'] ?? null);
        $data['logo'] = $data['logo'] ?? ($settings['logo'] ?? null);

        extract($data);

        $viewPath = dirname(__DIR__) . "/app/Views/{$name}.php";

        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            http_response_code(500);
            echo "Error: View '{$name}' not found at {$viewPath}";
        }
    }
}
