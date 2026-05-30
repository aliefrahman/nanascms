<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Setting;

class SettingController extends Controller
{
    /**
     * Display the settings management page.
     */
    public function index(): void
    {
        try {
            $settings = Setting::getSettings() ?? [
                'logo' => '',
                'brand_name' => '',
                'company_name' => '',
                'tagline' => '',
                'description' => '',
                'address' => '',
                'contact_number' => '',
                'company_email' => '',
                'latitude' => '',
                'longitude' => ''
            ];
        } catch (\PDOException $e) {
            $settings = [];
            $_SESSION['flash_error'] = 'Gagal mengambil data pengaturan: ' . $e->getMessage();
        }

        $this->view('settings/index', [
            'companyName' => Setting::get('company_name'),
            'tagline' => 'Pengaturan Sistem',
            'settings' => $settings,
        ]);
    }

    /**
     * Update settings.
     */
    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $logoPath = null;

            if (isset($_FILES['logo']) && $_FILES['logo']['error'] !== UPLOAD_ERR_NO_FILE) {
                if ($_FILES['logo']['error'] !== UPLOAD_ERR_OK) {
                    $_SESSION['flash_error'] = 'Gagal mengunggah logo.';
                    redirect('/settings');
                }

                $file = $_FILES['logo'];
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
                $maxSize = 2 * 1024 * 1024; // 2 MB

                if (!in_array($file['type'], $allowedTypes)) {
                    $_SESSION['flash_error'] = 'Format file logo tidak didukung. Hanya gambar (JPG, PNG, GIF, WEBP, SVG) yang diperbolehkan.';
                    redirect('/settings');
                }

                if ($file['size'] > $maxSize) {
                    $_SESSION['flash_error'] = 'Ukuran file logo terlalu besar. Maksimal 2 MB.';
                    redirect('/settings');
                }

                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $newFilename = 'logo_' . time() . '.' . $extension;
                $targetDir = dirname(dirname(__DIR__)) . '/public/uploads/settings/';

                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                if (move_uploaded_file($file['tmp_name'], $targetDir . $newFilename)) {
                    $logoPath = '/uploads/settings/' . $newFilename;

                    // Hapus logo lama dari server (jika ada)
                    $oldLogo = Setting::get('logo');
                    if (!empty($oldLogo) && strpos($oldLogo, '/uploads/') === 0) {
                        $oldPath = dirname(dirname(__DIR__)) . '/public' . $oldLogo;
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                    }
                } else {
                    $_SESSION['flash_error'] = 'Gagal menyimpan file logo.';
                    redirect('/settings');
                }
            }

            try {
                Setting::updateSettings([
                    'logo' => $logoPath ?? Setting::get('logo'),
                    'brand_name' => $_POST['brand_name'] ?? null,
                    'company_name' => $_POST['company_name'] ?? null,
                    'tagline' => $_POST['tagline'] ?? null,
                    'description' => $_POST['description'] ?? null,
                    'address' => $_POST['address'] ?? null,
                    'contact_number' => $_POST['contact_number'] ?? null,
                    'company_email' => $_POST['company_email'] ?? null,
                    'latitude' => $_POST['latitude'] ?? null,
                    'longitude' => $_POST['longitude'] ?? null,
                ]);
                $_SESSION['flash_success'] = 'Pengaturan berhasil diperbarui!';
            } catch (\PDOException $e) {
                $_SESSION['flash_error'] = 'Gagal memperbarui pengaturan: ' . $e->getMessage();
            }
        }
        redirect('/settings');
    }
}
