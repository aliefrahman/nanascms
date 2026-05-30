<?php
// Build menu hierarchy from $globalMenus
$menuTree = [];
if (!empty($globalMenus)) {
    foreach ($globalMenus as $menu) {
        if ($menu['parent_id'] === null) {
            $menuTree[$menu['id']] = $menu;
            $menuTree[$menu['id']]['children'] = [];
        }
    }
    foreach ($globalMenus as $menu) {
        if ($menu['parent_id'] !== null && isset($menuTree[$menu['parent_id']])) {
            $menuTree[$menu['parent_id']]['children'][] = $menu;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $tagline ?? 'Belum di isi Tagline di pengaturan sistem' ?> |
        <?= $companyName ?? 'Belum di isi Nama Perusahaan di pengaturan sistem' ?>
    </title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet">

    <!-- Compiled Tailwind CSS -->
    <link rel="stylesheet" href="<?= route('/assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= route('/assets/css/theme.css') ?>">

    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Theme Switcher Script & Styles -->
    <script>
        // Mencegah FOUC (Flash of Unstyled Content) saat memuat tema
        if (localStorage.theme === 'light' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: light)').matches)) {
            document.documentElement.classList.add('light-theme');
        }
    </script>
</head>

<body
    class="bg-dark-bg text-slate-100 font-sans antialiased overflow-x-hidden selection:bg-brand-primary selection:text-dark-bg">
    <!-- Header Navigation -->
    <header class="fixed top-0 left-0 right-0 z-50 glass-card border-b border-white/5 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="<?= route('/') ?>" class="flex items-center space-x-3 group">
                <!-- Logo: Glowing Pineapple Icon in SVG -->
                <?php if (!empty($logo)): ?>
                    <img src="<?= route($logo) ?>" alt="Logo Brand"
                        class="h-10 object-contain group-hover:scale-105 transition-transform duration-300">
                <?php else: ?>
                    <div
                        class="w-10 h-10 bg-linear-to-tr from-brand-secondary to-brand-primary rounded-xl flex items-center justify-center text-dark-bg shadow-lg shadow-brand-secondary/20 group-hover:scale-105 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 stroke-[2.5]" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor">
                            <!-- Pineapple crown leaves -->
                            <path d="M12 2v3M9.5 3.5l1.5 2.5M14.5 3.5l-1.5 2.5" />
                            <!-- Pineapple body shape -->
                            <rect x="7" y="9" width="10" height="12" rx="4" fill="currentColor" fill-opacity="0.1" />
                            <!-- Criss-cross skin patterns -->
                            <path d="M7 13l10 5M7 18l10-5M10 9l4 12" />
                        </svg>
                    </div>
                <?php endif; ?>
                <span
                    class="font-display font-extrabold text-xl tracking-tight text-white group-hover:text-brand-primary transition-colors duration-300">
                    <?php if (!empty($brandName)): ?>
                        <?= htmlspecialchars($brandName) ?>
                    <?php else: ?>
                        NANAS<span class="text-brand-primary">.DEV</span>
                    <?php endif; ?>
                </span>
            </a>

            <nav class="hidden md:flex items-center space-x-8">
                <?php if (!empty($menuTree)): ?>
                    <?php foreach ($menuTree as $item): ?>
                        <?php if (empty($item['children'])): ?>
                            <a href="<?= htmlspecialchars(str_starts_with($item['url'], '/') ? route($item['url']) : $item['url']) ?>"
                                class="text-sm font-medium text-slate-400 hover:text-white transition-colors font-sans">
                                <?= htmlspecialchars($item['title']) ?>
                            </a>
                        <?php else: ?>
                            <!-- Dropdown Menu Item -->
                            <div class="relative group">
                                <button class="text-sm font-medium text-slate-400 hover:text-white transition-colors font-sans flex items-center space-x-1 focus:outline-none py-2">
                                    <span><?= htmlspecialchars($item['title']) ?></span>
                                    <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-500 group-hover:rotate-180 transition-transform duration-300"></i>
                                </button>
                                <div class="absolute left-0 top-full pt-2 w-56 opacity-0 invisible group-hover:opacity-100 group-hover:visible translate-y-4 group-hover:translate-y-0 transition-all duration-300 ease-out z-50">
                                    <div class="rounded-2xl bg-dark-surface/90 border border-white/10 backdrop-blur-xl shadow-2xl shadow-black/50 p-2 relative overflow-hidden">
                                        <!-- Top highlight -->
                                        <div class="absolute top-0 left-0 right-0 h-px bg-linear-to-r from-transparent via-brand-primary/50 to-transparent"></div>
                                        
                                        <?php foreach ($item['children'] as $child): ?>
                                            <a href="<?= htmlspecialchars(str_starts_with($child['url'], '/') ? route($child['url']) : $child['url']) ?>"
                                                class="flex items-center px-4 py-3 rounded-xl text-xs font-semibold text-slate-300 hover:text-brand-primary hover:bg-white/5 transition-all group/link">
                                                <span class="transform group-hover/link:translate-x-1 transition-transform duration-300"><?= htmlspecialchars($child['title']) ?></span>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Fallback to static menus if empty -->
                    <a href="<?= route('/#about') ?>"
                        class="text-sm font-medium text-slate-400 hover:text-white transition-colors font-sans">Tentang
                        Kami</a>
                    <a href="<?= route('/#services') ?>"
                        class="text-sm font-medium text-slate-400 hover:text-white transition-colors font-sans">Layanan</a>
                    <a href="<?= route('/#portfolio') ?>"
                        class="text-sm font-medium text-slate-400 hover:text-white transition-colors font-sans">Portofolio</a>
                <?php endif; ?>
            </nav>

            <div class="flex items-center space-x-4">
                <!-- Theme Toggle Desktop -->
                <button title="Ganti Tema (Terang/Gelap)" aria-label="Ganti Tema"
                    class="theme-toggle-btn hidden md:flex items-center justify-center p-2.5 rounded-full bg-white/5 hover:bg-white/10 border border-white/5 hover:border-brand-primary/30 transition-all duration-300 text-slate-400 hover:text-brand-primary hover:scale-110 active:scale-95 focus:outline-none shadow-lg">
                    <i data-lucide="sun" class="w-4 h-4 icon-sun"></i>
                    <i data-lucide="moon" class="w-4 h-4 icon-moon hidden"></i>
                </button>

                <?php if (\Core\Auth::check()):
                    $headerUser = \Core\Auth::user();
                    $headerName = !empty($headerUser['fullname']) ? $headerUser['fullname'] : $headerUser['username'];
                    $headerAvatar = !empty($headerUser['avatar']) ? $headerUser['avatar'] : null;
                    $headerInitials = strtoupper(substr($headerName, 0, 1));
                    ?>
                    <!-- User Profile Dropdown -->
                    <div class="relative group">
                        <button
                            class="flex items-center space-x-2 p-1.5 rounded-full bg-white/5 hover:bg-white/10 border border-white/5 hover:border-brand-primary/30 transition-all duration-300 focus:outline-none">
                            <?php if ($headerAvatar): ?>
                                <img src="<?= htmlspecialchars($headerAvatar) ?>" alt="Avatar"
                                    class="w-8 h-8 rounded-full object-cover shadow-md">
                            <?php else: ?>
                                <div
                                    class="w-8 h-8 rounded-full bg-linear-to-tr from-brand-secondary to-brand-primary flex items-center justify-center text-dark-bg font-bold text-xs shadow-md">
                                    <?= $headerInitials ?>
                                </div>
                            <?php endif; ?>
                            <span
                                class="hidden sm:inline text-xs font-semibold text-slate-300 font-sans max-w-[120px] truncate"><?= htmlspecialchars($headerName) ?></span>
                            <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-500 mr-2 group-hover:rotate-180 transition-transform duration-300"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div
                            class="absolute right-0 top-full pt-3 w-64 opacity-0 invisible group-hover:opacity-100 group-hover:visible translate-y-4 group-hover:translate-y-0 transition-all duration-300 ease-out z-50">
                            <div class="rounded-2xl bg-dark-surface/90 border border-white/10 backdrop-blur-xl shadow-2xl shadow-black/50 p-2 relative overflow-hidden">
                                <div class="absolute top-0 left-0 right-0 h-px bg-linear-to-r from-transparent via-brand-primary/50 to-transparent"></div>
                                
                                <div class="px-4 py-3 border-b border-white/5 mb-2">
                                    <p class="text-[10px] uppercase tracking-wider text-slate-500 font-semibold mb-0.5">Masuk sebagai</p>
                                    <p class="text-sm font-bold text-white truncate"><?= htmlspecialchars($headerName) ?></p>
                                </div>

                                <a href="<?= route('/dashboard') ?>"
                                    class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:text-brand-primary hover:bg-white/5 transition-all group/link">
                                    <i data-lucide="layout-dashboard" class="w-4 h-4 group-hover/link:scale-110 transition-transform duration-300"></i>
                                    <span>Dashboard</span>
                                </a>
                                <a href="<?= route('/profile') ?>"
                                    class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:text-brand-primary hover:bg-white/5 transition-all group/link">
                                    <i data-lucide="user" class="w-4 h-4 group-hover/link:scale-110 transition-transform duration-300"></i>
                                    <span>Profil Saya</span>
                                </a>
                                <a href="<?= route('/media') ?>"
                                    class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:text-brand-primary hover:bg-white/5 transition-all group/link">
                                    <i data-lucide="image" class="w-4 h-4 group-hover/link:scale-110 transition-transform duration-300"></i>
                                    <span>Galeri Media</span>
                                </a>
                                <?php if (\Core\Auth::role() === 'Admin' || \Core\Auth::role() === 'Editor'): ?>
                                    <a href="<?= route('/categories') ?>"
                                        class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:text-brand-primary hover:bg-white/5 transition-all group/link">
                                        <i data-lucide="tag" class="w-4 h-4 group-hover/link:scale-110 transition-transform duration-300"></i>
                                        <span>Manajemen Kategori</span>
                                    </a>
                                    <a href="<?= route('/pages') ?>"
                                        class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:text-brand-primary hover:bg-white/5 transition-all group/link">
                                        <i data-lucide="file-text" class="w-4 h-4 group-hover/link:scale-110 transition-transform duration-300"></i>
                                        <span>Manajemen Halaman</span>
                                    </a>
                                <?php endif; ?>
                                <?php if (\Core\Auth::role() === 'Admin'): ?>
                                    <a href="<?= route('/users') ?>"
                                        class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:text-brand-primary hover:bg-white/5 transition-all group/link">
                                        <i data-lucide="users" class="w-4 h-4 group-hover/link:scale-110 transition-transform duration-300"></i>
                                        <span>Manajemen User</span>
                                    </a>
                                    <a href="<?= route('/settings') ?>"
                                        class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:text-brand-primary hover:bg-white/5 transition-all group/link">
                                        <i data-lucide="settings-2" class="w-4 h-4 group-hover/link:scale-110 transition-transform duration-300"></i>
                                        <span>Pengaturan Sistem</span>
                                    </a>
                                    <a href="<?= route('/menus') ?>"
                                        class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:text-brand-primary hover:bg-white/5 transition-all group/link">
                                        <i data-lucide="menu" class="w-4 h-4 group-hover/link:scale-110 transition-transform duration-300"></i>
                                        <span>Manajemen Menu</span>
                                    </a>
                                <?php endif; ?>
                                <div class="px-2 my-2">
                                    <div class="h-px w-full bg-white/5"></div>
                                </div>
                                <a href="<?= route('/logout') ?>"
                                    class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-xs font-semibold text-red-400 hover:bg-red-500/10 transition-all group/link">
                                    <i data-lucide="log-out" class="w-4 h-4 group-hover/link:scale-110 transition-transform duration-300"></i>
                                    <span>Keluar</span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?= route('/#contact') ?>"
                        class="hidden sm:inline-flex items-center justify-center px-5 py-2.5 rounded-full text-xs font-semibold uppercase tracking-wider text-dark-bg bg-brand-primary hover:bg-white hover:scale-105 active:scale-95 transition-all duration-300 shadow-lg shadow-brand-primary/25 font-sans">
                        Mulai Proyek
                    </a>
                <?php endif; ?>

                <!-- Mobile Menu Button (Interactive) -->
                <button id="mobile-menu-btn" class="md:hidden p-2 text-slate-400 hover:text-white transition-colors">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation Drawer -->
    <div id="mobile-menu"
        class="fixed inset-0 z-40 bg-dark-bg/95 backdrop-blur-lg translate-x-full transition-transform duration-500 md:hidden flex flex-col justify-center items-center space-y-8">
        <button id="mobile-close-btn" class="absolute top-6 right-6 p-2 text-slate-400 hover:text-white">
            <i data-lucide="x" class="w-8 h-8"></i>
        </button>
        <!-- Theme Toggle Mobile -->
        <button title="Ganti Tema (Terang/Gelap)" aria-label="Ganti Tema"
            class="theme-toggle-btn absolute top-6 left-6 p-2 text-slate-400 hover:text-brand-primary transition-all duration-300 hover:scale-110 active:scale-95">
            <i data-lucide="sun" class="w-7 h-7 icon-sun"></i>
            <i data-lucide="moon" class="w-7 h-7 icon-moon hidden"></i>
        </button>
        <?php if (!empty($menuTree)): ?>
            <?php foreach ($menuTree as $item): ?>
                <?php if (empty($item['children'])): ?>
                    <a href="<?= htmlspecialchars(str_starts_with($item['url'], '/') ? route($item['url']) : $item['url']) ?>"
                        class="mobile-nav-link text-2xl font-display font-bold hover:text-brand-primary transition-colors">
                        <?= htmlspecialchars($item['title']) ?>
                    </a>
                <?php else: ?>
                    <div class="flex flex-col items-center space-y-2">
                        <span class="text-xs font-semibold uppercase tracking-widest text-slate-500 font-sans mt-2">
                            <?= htmlspecialchars($item['title']) ?>
                        </span>
                        <?php foreach ($item['children'] as $child): ?>
                            <a href="<?= htmlspecialchars(str_starts_with($child['url'], '/') ? route($child['url']) : $child['url']) ?>"
                                class="mobile-nav-link text-lg font-display font-semibold hover:text-brand-primary transition-colors">
                                <?= htmlspecialchars($child['title']) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Fallback to static menus -->
            <a href="<?= route('/#about') ?>"
                class="mobile-nav-link text-2xl font-display font-bold hover:text-brand-primary transition-colors">Tentang
                Kami</a>
            <a href="<?= route('/#services') ?>"
                class="mobile-nav-link text-2xl font-display font-bold hover:text-brand-primary transition-colors">Layanan</a>
            <a href="<?= route('/#portfolio') ?>"
                class="mobile-nav-link text-2xl font-display font-bold hover:text-brand-primary transition-colors">Portfolio</a>
        <?php endif; ?>
        <?php if (\Core\Auth::check()): ?>
            <a href="<?= route('/dashboard') ?>"
                class="mobile-nav-link text-2xl font-display font-bold hover:text-brand-primary transition-colors">Dashboard</a>
            <a href="<?= route('/media') ?>"
                class="mobile-nav-link text-2xl font-display font-bold hover:text-brand-primary transition-colors">Galeri
                Media</a>
            <?php if (\Core\Auth::role() === 'Admin' || \Core\Auth::role() === 'Editor'): ?>
                <a href="<?= route('/categories') ?>"
                    class="mobile-nav-link text-2xl font-display font-bold hover:text-brand-primary transition-colors">Kategori</a>
                <a href="<?= route('/pages') ?>"
                    class="mobile-nav-link text-2xl font-display font-bold hover:text-brand-primary transition-colors">Halaman Statis</a>
            <?php endif; ?>
            <a href="<?= route('/profile') ?>"
                class="mobile-nav-link text-2xl font-display font-bold hover:text-brand-primary transition-colors">Profil
                Saya</a>
            <?php if (\Core\Auth::role() === 'Admin'): ?>
                <a href="<?= route('/users') ?>"
                    class="mobile-nav-link text-2xl font-display font-bold hover:text-brand-primary transition-colors">Manajemen
                    User</a>
                <a href="<?= route('/users/create') ?>"
                    class="mobile-nav-link text-2xl font-display font-bold hover:text-brand-primary transition-colors">Tambah
                    User</a>
                <a href="<?= route('/settings') ?>"
                    class="mobile-nav-link text-2xl font-display font-bold hover:text-brand-primary transition-colors">Pengaturan
                    Sistem</a>
                <a href="<?= route('/menus') ?>"
                    class="mobile-nav-link text-2xl font-display font-bold hover:text-brand-primary transition-colors">Manajemen
                    Menu</a>
            <?php endif; ?>
            <a href="<?= route('/logout') ?>"
                class="mobile-nav-link px-8 py-3 rounded-full text-sm font-semibold uppercase text-slate-400 border border-white/10 bg-white/5 hover:bg-red-500/10 hover:text-red-400 transition-all font-sans">
                Keluar
            </a>
        <?php else: ?>
            <a href="<?= route('/#testimonials') ?>"
                class="mobile-nav-link text-2xl font-display font-bold hover:text-brand-primary transition-colors">Testimoni</a>
            <a href="<?= route('/#contact') ?>"
                class="mobile-nav-link px-8 py-3 rounded-full text-sm font-semibold uppercase text-dark-bg bg-brand-primary hover:bg-white transition-all shadow-lg shadow-brand-primary/25 font-sans">
                Mulai Proyek
            </a>
        <?php endif; ?>
    </div>

    <!-- Main Content Slot -->
    <main class="pt-20">