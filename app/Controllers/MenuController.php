<?php

namespace App\Controllers;

use Core\Controller;
use Core\Auth;
use App\Models\Menu;
use App\Models\Setting;

class MenuController extends Controller
{
    /**
     * Display list of menu items.
     */
    public function index(): void
    {
        try {
            $menus = Menu::all();
        } catch (\PDOException $e) {
            $menus = [];
            $_SESSION['flash_error'] = 'Gagal mengambil data menu: ' . $e->getMessage();
        }

        $this->view('menus/index', [
            'companyName' => Setting::get('company_name'),
            'tagline' => 'Manajemen Menu',
            'menus' => $menus
        ]);
    }

    /**
     * Display form to create a new menu item.
     */
    public function create(): void
    {
        try {
            $menus = Menu::all();
        } catch (\PDOException $e) {
            $menus = [];
        }

        $this->view('menus/create', [
            'companyName' => Setting::get('company_name'),
            'tagline' => 'Tambah Menu Baru',
            'menus' => $menus
        ]);
    }

    /**
     * Process creation of a new menu item.
     */
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/menus');
        }

        $title = trim($_POST['title'] ?? '');
        $url = trim($_POST['url'] ?? '');
        $parentId = trim($_POST['parent_id'] ?? '');
        $sortOrder = isset($_POST['sort_order']) ? (int) $_POST['sort_order'] : 0;

        if (empty($title) || empty($url)) {
            $_SESSION['flash_error'] = 'Judul menu dan URL wajib diisi.';
            redirect('/menus/create');
        }

        $data = [
            'title' => $title,
            'url' => $url,
            'parent_id' => $parentId,
            'sort_order' => $sortOrder
        ];

        try {
            if (Menu::create($data)) {
                $_SESSION['flash_success'] = 'Menu baru berhasil ditambahkan!';
                redirect('/menus');
            } else {
                $_SESSION['flash_error'] = 'Gagal menambahkan menu baru.';
                redirect('/menus/create');
            }
        } catch (\PDOException $e) {
            $_SESSION['flash_error'] = 'Error: ' . $e->getMessage();
            redirect('/menus/create');
        }
    }

    /**
     * Display edit form for a menu item.
     */
    public function edit(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['flash_error'] = 'ID menu tidak valid.';
            redirect('/menus');
        }

        $currentMenu = Menu::find($id);
        if (!$currentMenu) {
            $_SESSION['flash_error'] = 'Menu tidak ditemukan.';
            redirect('/menus');
        }

        $hasChildren = false;
        try {
            // Check if the menu has any active children
            $stmt = \Core\Database::query("SELECT COUNT(*) FROM menus WHERE parent_id = ?", [$id]);
            $hasChildren = (int) $stmt->fetchColumn() > 0;

            // Fetch all menus to be used as parent options, excluding the current menu to prevent circular loops
            $allMenus = Menu::all();
            $menus = array_filter($allMenus, function ($item) use ($id) {
                return (int) $item['id'] !== $id;
            });
        } catch (\PDOException $e) {
            $menus = [];
        }

        $this->view('menus/edit', [
            'companyName' => Setting::get('company_name'),
            'tagline' => 'Edit Menu',
            'currentMenu' => $currentMenu,
            'menus' => $menus,
            'hasChildren' => $hasChildren
        ]);
    }

    /**
     * Process updating an existing menu item.
     */
    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/menus');
        }

        $id = (int) ($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $url = trim($_POST['url'] ?? '');
        $parentId = trim($_POST['parent_id'] ?? '');
        $sortOrder = isset($_POST['sort_order']) ? (int) $_POST['sort_order'] : 0;

        if ($id <= 0) {
            $_SESSION['flash_error'] = 'ID menu tidak valid.';
            redirect('/menus');
        }

        if (empty($title) || empty($url)) {
            $_SESSION['flash_error'] = 'Judul menu dan URL wajib diisi.';
            redirect("/menus/edit?id={$id}");
        }

        // Prevent setting a parent_id to itself
        if ($parentId !== 'root' && (int) $parentId === $id) {
            $_SESSION['flash_error'] = 'Menu tidak boleh menjadi sub-menu dari dirinya sendiri.';
            redirect("/menus/edit?id={$id}");
        }

        // Prevent circular reference
        if ($parentId !== 'root') {
            $checkId = (int) $parentId;
            $visited = [];
            while ($checkId > 0 && !isset($visited[$checkId])) {
                $visited[$checkId] = true;
                if ($checkId === $id) {
                    $_SESSION['flash_error'] = 'Pilihan parent menu tidak valid (menyebabkan circular loop).';
                    redirect("/menus/edit?id={$id}");
                }
                $parentMenu = Menu::find($checkId);
                $checkId = $parentMenu && $parentMenu['parent_id'] !== null ? (int) $parentMenu['parent_id'] : 0;
            }
        }

        // Prevent setting a parent if the menu currently has children (keep max nesting depth to 2)
        if ($parentId !== 'root') {
            try {
                $stmt = \Core\Database::query("SELECT COUNT(*) FROM menus WHERE parent_id = ?", [$id]);
                if ((int) $stmt->fetchColumn() > 0) {
                    $_SESSION['flash_error'] = 'Menu yang memiliki sub-menu tidak boleh dijadikan sub-menu dari menu lain.';
                    redirect("/menus/edit?id={$id}");
                }
            } catch (\PDOException $e) {
                // ignore
            }
        }

        $data = [
            'title' => $title,
            'url' => $url,
            'parent_id' => $parentId,
            'sort_order' => $sortOrder
        ];

        try {
            if (Menu::update($id, $data)) {
                $_SESSION['flash_success'] = 'Menu berhasil diperbarui!';
                redirect('/menus');
            } else {
                $_SESSION['flash_error'] = 'Gagal memperbarui menu.';
                redirect("/menus/edit?id={$id}");
            }
        } catch (\PDOException $e) {
            $_SESSION['flash_error'] = 'Error: ' . $e->getMessage();
            redirect("/menus/edit?id={$id}");
        }
    }

    /**
     * Delete a menu item.
     */
    public function delete(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['flash_error'] = 'ID menu tidak valid.';
            redirect('/menus');
        }

        try {
            if (Menu::delete($id)) {
                $_SESSION['flash_success'] = 'Menu berhasil dihapus!';
            } else {
                $_SESSION['flash_error'] = 'Gagal menghapus menu.';
            }
        } catch (\PDOException $e) {
            $_SESSION['flash_error'] = 'Gagal menghapus menu: ' . $e->getMessage();
        }

        redirect('/menus');
    }
}
