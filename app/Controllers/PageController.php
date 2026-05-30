<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Page;
use App\Models\Setting;
use Core\Config;
use Core\Auth;

class PageController extends Controller
{
    /**
     * Display list of pages for Admin / Editor.
     */
    public function index(): void
    {
        try {
            $pages = Page::all();
        } catch (\PDOException $e) {
            $pages = [];
            $_SESSION['flash_error'] = 'Gagal mengambil data halaman: ' . $e->getMessage();
        }

        $this->view('pages/index', [
            'companyName' => Setting::get('company_name'),
            'tagline' => 'Manajemen Halaman',
            'pages' => $pages
        ]);
    }

    /**
     * Show form to create a new page.
     */
    public function create(): void
    {
        $this->view('pages/create', [
            'companyName' => Setting::get('company_name'),
            'tagline' => 'Tambah Halaman Baru'
        ]);
    }

    /**
     * Store new page in database.
     */
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/pages');
        }

        $title = trim($_POST['title'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $content = $_POST['content'] ?? '';
        $status = $_POST['status'] ?? 'draft';

        if (empty($title)) {
            $_SESSION['flash_error'] = 'Judul halaman wajib diisi.';
            redirect('/pages/create');
        }

        $data = [
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'status' => $status
        ];

        try {
            if (Page::create($data)) {
                $_SESSION['flash_success'] = 'Halaman baru berhasil ditambahkan!';
                redirect('/pages');
            } else {
                $_SESSION['flash_error'] = 'Gagal menambahkan halaman baru.';
                redirect('/pages/create');
            }
        } catch (\PDOException $e) {
            $_SESSION['flash_error'] = 'Error: ' . $e->getMessage();
            redirect('/pages/create');
        }
    }

    /**
     * Show form to edit an existing page.
     */
    public function edit(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['flash_error'] = 'ID halaman tidak valid.';
            redirect('/pages');
        }

        $page = Page::find($id);
        if (!$page) {
            $_SESSION['flash_error'] = 'Halaman tidak ditemukan.';
            redirect('/pages');
        }

        $this->view('pages/edit', [
            'companyName' => Setting::get('company_name'),
            'tagline' => 'Edit Halaman',
            'page' => $page
        ]);
    }

    /**
     * Update an existing page.
     */
    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/pages');
        }

        $id = (int) ($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $content = $_POST['content'] ?? '';
        $status = $_POST['status'] ?? 'draft';

        if ($id <= 0) {
            $_SESSION['flash_error'] = 'ID halaman tidak valid.';
            redirect('/pages');
        }

        if (empty($title)) {
            $_SESSION['flash_error'] = 'Judul halaman wajib diisi.';
            redirect("/pages/edit?id={$id}");
        }

        $data = [
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'status' => $status
        ];

        try {
            if (Page::update($id, $data)) {
                $_SESSION['flash_success'] = 'Halaman berhasil diperbarui!';
                redirect('/pages');
            } else {
                $_SESSION['flash_error'] = 'Gagal memperbarui halaman.';
                redirect("/pages/edit?id={$id}");
            }
        } catch (\PDOException $e) {
            $_SESSION['flash_error'] = 'Error: ' . $e->getMessage();
            redirect("/pages/edit?id={$id}");
        }
    }

    /**
     * Delete a page.
     */
    public function delete(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['flash_error'] = 'ID halaman tidak valid.';
            redirect('/pages');
        }

        try {
            if (Page::delete($id)) {
                $_SESSION['flash_success'] = 'Halaman berhasil dihapus!';
            } else {
                $_SESSION['flash_error'] = 'Gagal menghapus halaman.';
            }
        } catch (\PDOException $e) {
            $_SESSION['flash_error'] = 'Gagal menghapus halaman: ' . $e->getMessage();
        }

        redirect('/pages');
    }

    /**
     * Render the public view of a static page.
     *
     * @param string $slug
     */
    public function show(string $slug): void
    {
        // Cek jika aplikasi dalam mode development dan user belum login
        if (Config::get('app.env') === 'development' && !Auth::check()) {
            $this->view('maintenance', [
                'companyName' => Setting::get('company_name'),
                'tagline' => 'Sedang Dalam Perbaikan'
            ]);
            return;
        }

        $page = Page::findBySlug($slug);

        // Only allow viewing published pages in the public layout
        if (!$page || $page['status'] !== 'published') {
            http_response_code(404);
            $this->view('errors/404', [
                'companyName' => Setting::get('company_name'),
                'tagline' => 'Halaman Tidak Ditemukan'
            ]);
            return;
        }

        $this->view('pages/show', [
            'companyName' => Setting::get('company_name'),
            'tagline' => $page['title'],
            'page' => $page
        ]);
    }
}
