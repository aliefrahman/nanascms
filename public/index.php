<?php

// 1. Start Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Global Routing Helpers for subdirectory support
function route(string $path): string
{
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $basePath = dirname($scriptName);
    if ($basePath === '/' || $basePath === '\\') {
        $basePath = '';
    }
    return $basePath . '/' . ltrim($path, '/');
}

function redirect(string $path): void
{
    header('Location: ' . route($path));
    exit;
}

// 2. Register Simple Autoloader (Core\ -> core/, App\ -> app/)
spl_autoload_register(function ($class) {
    $classPath = str_replace('\\', '/', $class);
    $parts = explode('/', $classPath);
    if (empty($parts))
        return;

    // Lowercase the first namespace level to match directories: Core -> core, App -> app
    $parts[0] = strtolower($parts[0]);
    $file = dirname(__DIR__) . '/' . implode('/', $parts) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

// 3. Define and resolve routes
use Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\UserController;
use App\Controllers\ProfileController;
use App\Controllers\MediaController;
use App\Controllers\CategoryController;
use App\Controllers\SettingController;
use App\Controllers\MenuController;
use App\Controllers\PageController;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\GuestMiddleware;
use App\Middlewares\AdminMiddleware;
use App\Middlewares\AdminOrEditorMiddleware;

$router = new Router();

// Route configuration
$router->get('/', [HomeController::class, 'index']);

// Authentication Routes
$router->get('/login', [AuthController::class, 'showLoginForm'])->middleware([GuestMiddleware::class]);
$router->post('/login', [AuthController::class, 'login'])->middleware([GuestMiddleware::class]);
$router->get('/register', [AuthController::class, 'showRegisterForm'])->middleware([GuestMiddleware::class]);
$router->post('/register', [AuthController::class, 'register'])->middleware([GuestMiddleware::class]);
$router->get('/logout', [AuthController::class, 'logout']);

// Dashboard Control Panel
$router->get('/dashboard', [DashboardController::class, 'index'])->middleware([AuthMiddleware::class]);

// User Profile Settings
$router->get('/profile', [ProfileController::class, 'index'])->middleware([AuthMiddleware::class]);
$router->post('/profile/update', [ProfileController::class, 'update'])->middleware([AuthMiddleware::class]);

// Media Management (Centralized gallery)
$router->get('/media', [MediaController::class, 'index'])->middleware([AuthMiddleware::class]);
$router->post('/media/upload', [MediaController::class, 'upload'])->middleware([AuthMiddleware::class]);
$router->get('/media/delete', [MediaController::class, 'delete'])->middleware([AuthMiddleware::class]);
$router->get('/api/media', [MediaController::class, 'apiList'])->middleware([AuthMiddleware::class]);
$router->post('/api/media/upload', [MediaController::class, 'apiUpload'])->middleware([AuthMiddleware::class]);

// User Management (CRUD)
$router->get('/users', [UserController::class, 'index'])->middleware([AdminMiddleware::class]);
$router->get('/users/create', [UserController::class, 'create'])->middleware([AdminMiddleware::class]);
$router->post('/users/store', [UserController::class, 'store'])->middleware([AdminMiddleware::class]);
$router->get('/users/edit', [UserController::class, 'edit'])->middleware([AdminMiddleware::class]);
$router->post('/users/update', [UserController::class, 'update'])->middleware([AdminMiddleware::class]);
$router->get('/users/delete', [UserController::class, 'delete'])->middleware([AdminMiddleware::class]);

// Category Management (Admin & Editor only)
$router->get('/categories', [CategoryController::class, 'index'])->middleware([AdminOrEditorMiddleware::class]);
$router->get('/categories/create', [CategoryController::class, 'create'])->middleware([AdminOrEditorMiddleware::class]);
$router->post('/categories/store', [CategoryController::class, 'store'])->middleware([AdminOrEditorMiddleware::class]);
$router->get('/categories/edit', [CategoryController::class, 'edit'])->middleware([AdminOrEditorMiddleware::class]);
$router->post('/categories/update', [CategoryController::class, 'update'])->middleware([AdminOrEditorMiddleware::class]);
$router->get('/categories/delete', [CategoryController::class, 'delete'])->middleware([AdminOrEditorMiddleware::class]);

// Settings Management (Admin only)
$router->get('/settings', [SettingController::class, 'index'])->middleware([AdminMiddleware::class]);
$router->get('/settings/create', [SettingController::class, 'create'])->middleware([AdminMiddleware::class]);
$router->post('/settings/store', [SettingController::class, 'store'])->middleware([AdminMiddleware::class]);
$router->get('/settings/edit', [SettingController::class, 'edit'])->middleware([AdminMiddleware::class]);
$router->post('/settings/update', [SettingController::class, 'update'])->middleware([AdminMiddleware::class]);
$router->get('/settings/delete', [SettingController::class, 'delete'])->middleware([AdminMiddleware::class]);

// Menu Management (Admin only)
$router->get('/menus', [MenuController::class, 'index'])->middleware([AdminMiddleware::class]);
$router->get('/menus/create', [MenuController::class, 'create'])->middleware([AdminMiddleware::class]);
$router->post('/menus/store', [MenuController::class, 'store'])->middleware([AdminMiddleware::class]);
$router->get('/menus/edit', [MenuController::class, 'edit'])->middleware([AdminMiddleware::class]);
$router->post('/menus/update', [MenuController::class, 'update'])->middleware([AdminMiddleware::class]);
$router->get('/menus/delete', [MenuController::class, 'delete'])->middleware([AdminMiddleware::class]);

// Page Management (Admin & Editor only)
$router->get('/pages', [PageController::class, 'index'])->middleware([AdminOrEditorMiddleware::class]);
$router->get('/pages/create', [PageController::class, 'create'])->middleware([AdminOrEditorMiddleware::class]);
$router->post('/pages/store', [PageController::class, 'store'])->middleware([AdminOrEditorMiddleware::class]);
$router->get('/pages/edit', [PageController::class, 'edit'])->middleware([AdminOrEditorMiddleware::class]);
$router->post('/pages/update', [PageController::class, 'update'])->middleware([AdminOrEditorMiddleware::class]);
$router->get('/pages/delete', [PageController::class, 'delete'])->middleware([AdminOrEditorMiddleware::class]);

// Dynamic Static Pages Routing (Clean URLs /p/{slug})
try {
    $publishedPages = \App\Models\Page::allPublished();
    foreach ($publishedPages as $p) {
        $router->get('/p/' . $p['slug'], function() use ($p) {
            $controller = new PageController();
            $controller->show($p['slug']);
        });
    }
} catch (\Exception $e) {
    // Avoid crashing if pages table doesn't exist
}

// Run application
$router->resolve();
