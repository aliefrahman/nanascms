<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Category;
use App\Models\Setting;

class CategoryController extends Controller
{
    /**
     * Display list of categories.
     */
    public function index(): void
    {
        try {
            $categories = Category::all();
        } catch (\PDOException $e) {
            $categories = [];
            $_SESSION['flash_error'] = 'Gagal mengambil data kategori: ' . $e->getMessage();
        }

        $this->view('categories/index', [
            'companyName' => Setting::get('company_name'),
            'tagline' => 'Manajemen Kategori',
            'categories' => $categories
        ]);
    }

    /**
     * Display creation form.
     */
    public function create(): void
    {
        $this->view('categories/create', [
            'companyName' => 'Nanas Home Studio',
            'tagline' => 'Tambah Kategori Baru'
        ]);
    }

    /**
     * Store new category.
     */
    public function store(): void
    {
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if (empty($name)) {
            $_SESSION['flash_error'] = 'Nama kategori wajib diisi.';
            redirect('/categories/create');
        }

        try {
            // Auto generate unique slug
            $slug = Category::getUniqueSlug($name);

            $data = [
                'name' => $name,
                'slug' => $slug,
                'description' => $description ?: null
            ];

            Category::create($data);

            $_SESSION['flash_success'] = 'Kategori berhasil ditambahkan!';
            redirect('/categories');
        } catch (\PDOException $e) {
            $_SESSION['flash_error'] = 'Gagal menambahkan kategori: ' . $e->getMessage();
            redirect('/categories/create');
        }
    }

    /**
     * Display edit form.
     */
    public function edit(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['flash_error'] = 'ID kategori tidak valid.';
            redirect('/categories');
        }

        $category = Category::find($id);
        if (!$category) {
            $_SESSION['flash_error'] = 'Kategori tidak ditemukan.';
            redirect('/categories');
        }

        $this->view('categories/edit', [
            'companyName' => 'Nanas Home Studio',
            'tagline' => 'Edit Kategori',
            'category' => $category
        ]);
    }

    /**
     * Update category.
     */
    public function update(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['flash_error'] = 'ID kategori tidak valid.';
            redirect('/categories');
        }

        $name = trim($_POST['name'] ?? '');
        $slugInput = trim($_POST['slug'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if (empty($name)) {
            $_SESSION['flash_error'] = 'Nama kategori wajib diisi.';
            redirect('/categories/edit?id=' . $id);
        }

        try {
            // Generate/validate unique slug
            $targetSlug = !empty($slugInput) ? $slugInput : $name;
            $slug = Category::getUniqueSlug($targetSlug, $id);

            $data = [
                'name' => $name,
                'slug' => $slug,
                'description' => $description ?: null
            ];

            Category::update($id, $data);

            $_SESSION['flash_success'] = 'Kategori berhasil diperbarui!';
            redirect('/categories');
        } catch (\PDOException $e) {
            $_SESSION['flash_error'] = 'Gagal memperbarui kategori: ' . $e->getMessage();
            redirect('/categories/edit?id=' . $id);
        }
    }

    /**
     * Delete category.
     */
    public function delete(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['flash_error'] = 'ID kategori tidak valid.';
            redirect('/categories');
        }

        try {
            $category = Category::find($id);
            if (!$category) {
                $_SESSION['flash_error'] = 'Kategori tidak ditemukan.';
                redirect('/categories');
            }

            Category::delete($id);

            $_SESSION['flash_success'] = 'Kategori berhasil dihapus!';
            redirect('/categories');
        } catch (\PDOException $e) {
            $_SESSION['flash_error'] = 'Gagal menghapus kategori: ' . $e->getMessage();
            redirect('/categories');
        }
    }
}
