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
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap"
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
    class="bg-dark-bg text-slate-100 font-sans antialiased min-h-screen flex items-center justify-center relative overflow-hidden px-6 dot-bg">
    <!-- Ambient glow background blobs -->
    <div class="blur-blob w-96 h-96 bg-brand-primary/10 -top-20 -left-20 animate-pulse-slow"></div>
    <div class="blur-blob w-96 h-96 bg-brand-emerald/10 -bottom-20 -right-20 animate-float-slow"></div>

    <div class="w-full max-w-md relative z-10">
        <!-- Back to Home -->
        <a href="<?= route('/') ?>"
            class="inline-flex items-center text-xs font-semibold text-slate-400 hover:text-brand-primary mb-8 transition-colors group">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform"></i>
            <span>Kembali ke Beranda</span>
        </a>

        <!-- Glassmorphic Card -->
        <div class="glass-card p-10 md:p-12 rounded-3xl border border-white/5 shadow-2xl relative overflow-hidden">
            <div
                class="absolute top-0 right-0 w-24 h-24 bg-linear-to-br from-brand-primary to-brand-emerald opacity-5 blur-2xl">
            </div>

            <div class="text-center mb-8">
                <!-- Glowing Logo -->
                <div
                    class="w-12 h-12 bg-linear-to-tr from-brand-secondary to-brand-primary rounded-2xl flex items-center justify-center text-dark-bg mx-auto mb-4 shadow-lg shadow-brand-primary/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 stroke-[2.5]" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path d="M12 2v3M9.5 3.5l1.5 2.5M14.5 3.5l-1.5 2.5" />
                        <rect x="7" y="9" width="10" height="12" rx="4" fill="currentColor" fill-opacity="0.1" />
                        <path d="M7 13l10 5M7 18l10-5M10 9l4 12" />
                    </svg>
                </div>
                <h2 class="font-display font-extrabold text-2xl text-white">Selamat Datang</h2>
                <p class="text-xs text-slate-400 mt-2">Silakan masuk menggunakan akun Anda</p>
            </div>

            <!-- Flash Session Alerts -->
            <?php if (isset($_SESSION['flash_error'])): ?>
                <div
                    class="mb-6 p-4 rounded-xl border border-red-500/20 bg-red-500/10 text-red-400 text-xs flex items-start space-x-2">
                    <i data-lucide="alert-circle" class="w-4 h-4 shrink-0 mt-0.5"></i>
                    <span><?= $_SESSION['flash_error'];
                    unset($_SESSION['flash_error']); ?></span>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['flash_success'])): ?>
                <div
                    class="mb-6 p-4 rounded-xl border border-emerald-500/20 bg-emerald-500/10 text-emerald-400 text-xs flex items-start space-x-2">
                    <i data-lucide="check-circle" class="w-4 h-4 shrink-0 mt-0.5"></i>
                    <span><?= $_SESSION['flash_success'];
                    unset($_SESSION['flash_success']); ?></span>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="<?= route('/login') ?>" method="POST" class="space-y-6">
                <div class="space-y-2">
                    <label for="login" class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Username
                        atau Email</label>
                    <div class="relative">
                        <i data-lucide="user"
                            class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"></i>
                        <input type="text" id="login" name="login" required
                            class="w-full pl-11 pr-5 py-4 rounded-xl bg-dark-bg/60 border border-white/10 focus:border-brand-primary/50 text-white placeholder-slate-600 focus:outline-none transition-colors text-sm"
                            placeholder="Masukkan username/email">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="password" class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kata
                        Sandi</label>
                    <div class="relative">
                        <i data-lucide="lock"
                            class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"></i>
                        <input type="password" id="password" name="password" required
                            class="w-full pl-11 pr-5 py-4 rounded-xl bg-dark-bg/60 border border-white/10 focus:border-brand-primary/50 text-white placeholder-slate-600 focus:outline-none transition-colors text-sm"
                            placeholder="Masukkan password">
                    </div>
                </div>

                <button type="submit"
                    class="w-full py-4 rounded-full font-bold text-dark-bg bg-brand-primary hover:bg-white hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 shadow-lg shadow-brand-primary/20 flex items-center justify-center space-x-2 text-sm mt-8">
                    <span>Masuk ke Dashboard</span>
                    <i data-lucide="log-in" class="w-4 h-4"></i>
                </button>
            </form>

            <div class="mt-8 text-center text-xs text-slate-500">
                <span>Belum punya akun?</span>
                <a href="<?= route('/register') ?>" class="text-brand-primary font-semibold hover:underline ml-1">Daftar
                    sekarang</a>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>