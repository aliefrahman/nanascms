</main>

<!-- Footer -->
<footer class="border-t border-white/5 bg-dark-bg relative overflow-hidden py-16">
    <!-- Blur blob in footer -->
    <div class="blur-blob w-80 h-80 bg-brand-primary/10 bottom-0 right-0"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <div class="md:col-span-1">
                <a href="#" class="flex items-center space-x-3 mb-6">
                    <?php if (!empty($logo)): ?>
                        <img src="<?= route($logo) ?>" alt="Logo Footer" class="h-8 object-contain rounded-lg">
                    <?php else: ?>
                        <div
                            class="w-8 h-8 bg-linear-to-tr from-brand-secondary to-brand-primary rounded-lg flex items-center justify-center text-dark-bg">
                            <i data-lucide="sparkles" class="w-4 h-4"></i>
                        </div>
                    <?php endif; ?>
                    <span class="font-display font-extrabold text-lg tracking-tight text-white">
                        <?php if (!empty($brandName)): ?>
                            <?= htmlspecialchars($brandName) ?>
                        <?php else: ?>
                            NANAS<span class="text-brand-primary">.CMS</span>
                        <?php endif; ?>
                    </span>
                </a>
                <p class="text-sm text-slate-400 max-w-sm mb-6">
                    <?php if (!empty($description)): ?>
                        <?= htmlspecialchars($description) ?>
                    <?php else: ?>
                        isi deskripsi perusahaan anda pada pengaturan sistem
                    <?php endif; ?>
                </p>
                <div class="flex space-x-4">
                    <a href="#"
                        class="w-10 h-10 rounded-full border border-white/5 hover:border-brand-primary/30 flex items-center justify-center text-slate-400 hover:text-brand-primary transition-colors">
                        <i data-lucide="instagram" class="w-5 h-5"></i>
                    </a>
                    <a href="#"
                        class="w-10 h-10 rounded-full border border-white/5 hover:border-brand-primary/30 flex items-center justify-center text-slate-400 hover:text-brand-primary transition-colors">
                        <i data-lucide="twitter" class="w-5 h-5"></i>
                    </a>
                    <a href="#"
                        class="w-10 h-10 rounded-full border border-white/5 hover:border-brand-primary/30 flex items-center justify-center text-slate-400 hover:text-brand-primary transition-colors">
                        <i data-lucide="linkedin" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="font-display font-bold text-sm text-white uppercase tracking-wider mb-6">Tautan</h4>
                <ul class="space-y-4">
                    <li><a href="<?= route('/#about') ?>"
                            class="text-sm text-slate-400 hover:text-white transition-colors animate-delay-75">Tentang</a>
                    </li>
                    <li><a href="<?= route('/#services') ?>"
                            class="text-sm text-slate-400 hover:text-white transition-colors">Layanan</a></li>
                    <li><a href="<?= route('/#portfolio') ?>"
                            class="text-sm text-slate-400 hover:text-white transition-colors">Portofolio</a></li>
                    <li><a href="<?= route('/#contact') ?>"
                            class="text-sm text-slate-400 hover:text-white transition-colors">Kontak</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-display font-bold text-sm text-white uppercase tracking-wider mb-6">Lokasi Kami</h4>
                <?php if (!empty($latitude) && !empty($longitude)): ?>
                    <div class="rounded-xl overflow-hidden border border-white/10 h-48 relative group">
                        <iframe width="100%" height="100%" frameborder="0" scrolling="no"
                            src="https://maps.google.com/maps?q=<?= htmlspecialchars($latitude) ?>,<?= htmlspecialchars($longitude) ?>&hl=id&z=15&output=embed"
                            class="absolute inset-0 grayscale-[0.3] group-hover:grayscale-0 transition-all duration-500"></iframe>
                    </div>
                <?php else: ?>
                    <div
                        class="rounded-xl border border-white/10 bg-white/5 h-48 flex items-center justify-center p-4 text-center">
                        <p class="text-xs text-slate-500">Koordinat peta belum diatur pada pengaturan sistem.</p>
                    </div>
                <?php endif; ?>
            </div>
            <div>
                <h4 class="font-display font-bold text-sm text-white uppercase tracking-wider mb-6">Kontak Kami</h4>

                <?php if (!empty($companyName)): ?>
                    <p class="text-sm font-semibold text-slate-200 mb-2"><?= htmlspecialchars($companyName) ?></p>
                <?php endif; ?>

                <p class="text-sm text-slate-400 mb-2">
                    <?php if (!empty($companyEmail)): ?>
                        <a href="mailto:<?= htmlspecialchars($companyEmail) ?>"
                            class="hover:text-brand-primary transition-colors"><?= htmlspecialchars($companyEmail) ?></a>
                    <?php else: ?>
                        isi email perusahaan pada pengaturan sistem
                    <?php endif; ?>
                </p>

                <p class="text-sm text-slate-400 mb-4">
                    <?php if (!empty($contactNumber)): ?>
                        <?= htmlspecialchars($contactNumber) ?>
                    <?php else: ?>
                        isi nomor kontak pada pengaturan sistem
                    <?php endif; ?>
                </p>

                <p class="text-sm text-slate-400">
                    <?php if (!empty($address)): ?>
                        <?= nl2br(htmlspecialchars($address)) ?>
                    <?php else: ?>
                        isi alamat lengkap perusahaan pada pengaturan sistem
                    <?php endif; ?>
                </p>
            </div>
        </div>

        <div
            class="pt-8 border-t border-white/5 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-slate-500">
            <p>&copy; <?= date('Y') ?> <?= $companyName ?? 'Nanas Home Studio' ?>. Hak cipta dilindungi.</p>
            <div class="flex space-x-6">
                <a href="#" class="hover:text-slate-300">Kebijakan Privasi</a>
                <a href="#" class="hover:text-slate-300">Syarat & Ketentuan</a>
            </div>
        </div>
    </div>
</footer>

<!-- Interactive Navigation Scripts -->
<script>
    // Init Lucide
    lucide.createIcons();

    // Mobile Menu Toggling
    const menuBtn = document.getElementById('mobile-menu-btn');
    const closeBtn = document.getElementById('mobile-close-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileLinks = document.querySelectorAll('.mobile-nav-link');

    function toggleMenu() {
        mobileMenu.classList.toggle('translate-x-full');
    }

    if (menuBtn && closeBtn && mobileMenu) {
        menuBtn.addEventListener('click', toggleMenu);
        closeBtn.addEventListener('click', toggleMenu);
        mobileLinks.forEach(link => link.addEventListener('click', toggleMenu));
    }

    // Glass Header Sticky Effect
    const header = document.querySelector('header');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.classList.add('py-2', 'bg-dark-bg/85', 'backdrop-blur-md');
        } else {
            header.classList.remove('py-2', 'bg-dark-bg/85', 'backdrop-blur-md');
        }
    });

    // Theme Switcher Click Handlers
    const themeToggleBtns = document.querySelectorAll('.theme-toggle-btn');
    themeToggleBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            if (document.documentElement.classList.contains('light-theme')) {
                document.documentElement.classList.remove('light-theme');
                localStorage.theme = 'dark';
            } else {
                document.documentElement.classList.add('light-theme');
                localStorage.theme = 'light';
            }
        });
    });
</script>
</body>

</html>