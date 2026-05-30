<?php

namespace App\Controllers;

use Core\Controller;
use Core\Auth;
use App\Models\Media;
use App\Models\Setting;

class MediaController extends Controller
{
    /**
     * Display centralized media manager page.
     */
    public function index(): void
    {
        $mediaItems = [];
        try {
            $currentUser = Auth::user();
            $mediaItems = Media::allByUserId($currentUser['id']);
        } catch (\PDOException $e) {
            $_SESSION['flash_error'] = 'Gagal memuat media: ' . $e->getMessage();
        }

        $this->view('media/index', [
            'companyName' => Setting::get('company_name'),
            'tagline' => 'Manajemen Media',
            'mediaItems' => $mediaItems
        ]);
    }

    /**
     * Process file upload.
     */
    public function upload(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/media');
        }

        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['flash_error'] = 'Gagal mengunggah file. Silakan pilih file yang valid.';
            redirect('/media');
        }

        $file = $_FILES['file'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
        $maxSize = 5 * 1024 * 1024; // 5 MB

        if (!in_array($file['type'], $allowedTypes)) {
            $_SESSION['flash_error'] = 'Format file tidak didukung. Hanya gambar (JPG, PNG, GIF, WEBP, SVG) yang diperbolehkan.';
            redirect('/media');
        }

        if ($file['size'] > $maxSize) {
            $_SESSION['flash_error'] = 'Ukuran file terlalu besar. Maksimal ukuran file adalah 5 MB.';
            redirect('/media');
        }

        // Generate a safe unique name
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $safeName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', pathinfo($file['name'], PATHINFO_FILENAME));
        $newFilename = uniqid('media_', true) . '_' . $safeName . '.' . $extension;

        $targetDir = dirname(dirname(__DIR__)) . '/public/uploads/';
        $targetFile = $targetDir . $newFilename;

        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            try {
                $currentUser = Auth::user();
                Media::create([
                    'user_id' => $currentUser['id'],
                    'filename' => $newFilename,
                    'original_name' => $file['name'],
                    'file_path' => '/uploads/' . $newFilename,
                    'file_type' => $file['type'],
                    'file_size' => $file['size']
                ]);
                $_SESSION['flash_success'] = 'File berhasil diunggah dan disimpan ke media!';
            } catch (\PDOException $e) {
                $_SESSION['flash_error'] = 'Gagal menyimpan data ke database: ' . $e->getMessage();
            }
        } else {
            $_SESSION['flash_error'] = 'Gagal memindahkan file yang diunggah ke server.';
        }

        redirect('/media');
    }

    /**
     * Delete media item.
     */
    public function delete(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['flash_error'] = 'ID media tidak valid.';
            redirect('/media');
        }

        try {
            $media = Media::find($id);
            $currentUser = Auth::user();
            if ($media) {
                // Enforce ownership check
                if ((int) $media['user_id'] !== (int) $currentUser['id']) {
                    $_SESSION['flash_error'] = 'Anda tidak memiliki hak untuk menghapus file ini.';
                    redirect('/media');
                }

                // Delete physical file
                $filePath = dirname(dirname(__DIR__)) . '/public' . $media['file_path'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                // Delete database entry
                Media::delete($id);
                $_SESSION['flash_success'] = 'Media berhasil dihapus dari server.';
            } else {
                $_SESSION['flash_error'] = 'Media tidak ditemukan.';
            }
        } catch (\PDOException $e) {
            $_SESSION['flash_error'] = 'Kesalahan database saat menghapus media: ' . $e->getMessage();
        }

        redirect('/media');
    }

    /**
     * JSON API Endpoint: List all media.
     */
    public function apiList(): void
    {
        header('Content-Type: application/json');
        try {
            $currentUser = Auth::user();
            $media = Media::allByUserId($currentUser['id']);
            $result = array_map(function ($item) {
                return [
                    'id' => $item['id'],
                    'filename' => $item['original_name'],
                    'url' => route($item['file_path']),
                    'filetype' => $item['file_type'],
                    'filesize' => $item['file_size'],
                    'created_at' => $item['created_at']
                ];
            }, $media);
            echo json_encode(['success' => true, 'media' => $result]);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }

    /**
     * JSON API Endpoint: Asynchronous upload.
     */
    public function apiUpload(): void
    {
        header('Content-Type: application/json');

        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'error' => 'Gagal mengunggah file.']);
            exit;
        }

        $file = $_FILES['file'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
        $maxSize = 5 * 1024 * 1024;

        if (!in_array($file['type'], $allowedTypes)) {
            echo json_encode(['success' => false, 'error' => 'Format file tidak didukung.']);
            exit;
        }

        if ($file['size'] > $maxSize) {
            echo json_encode(['success' => false, 'error' => 'Ukuran file maksimal 5 MB.']);
            exit;
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $safeName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', pathinfo($file['name'], PATHINFO_FILENAME));
        $newFilename = uniqid('media_', true) . '_' . $safeName . '.' . $extension;

        $targetDir = dirname(dirname(__DIR__)) . '/public/uploads/';
        $targetFile = $targetDir . $newFilename;

        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            try {
                $filepath = '/uploads/' . $newFilename;
                $currentUser = Auth::user();
                Media::create([
                    'user_id' => $currentUser['id'],
                    'filename' => $newFilename,
                    'original_name' => $file['name'],
                    'file_path' => $filepath,
                    'file_type' => $file['type'],
                    'file_size' => $file['size']
                ]);
                echo json_encode([
                    'success' => true,
                    'url' => route($filepath)
                ]);
            } catch (\PDOException $e) {
                echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Gagal menyimpan file ke uploads.']);
        }
        exit;
    }
}
