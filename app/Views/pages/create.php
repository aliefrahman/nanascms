<?php include __DIR__ . '/../layout/header.php'; ?>

<!-- Pages Create Container -->
<div class="max-w-4xl mx-auto px-6 mt-10 relative z-10 pb-12 font-sans">
    <!-- Ambient background blobs -->
    <div class="blur-blob w-100 h-100 bg-brand-primary/5 -top-10 -left-10 animate-pulse-slow"></div>

    <!-- Page Title / Breadcrumb -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="font-display font-extrabold text-3xl text-white">Tambah Halaman</h1>
            <p class="text-xs text-slate-500 mt-1">Buat halaman statis baru untuk publikasi informasi website.</p>
        </div>

        <a href="<?= route('/pages') ?>"
            class="inline-flex items-center text-xs font-semibold text-slate-400 hover:text-brand-primary transition-colors group">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform"></i>
            <span>Kembali ke Halaman</span>
        </a>
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

    <!-- Form Card -->
    <div class="glass-card p-8 rounded-3xl border border-white/5">
        <form action="<?= route('/pages/store') ?>" method="POST" class="space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Page Title -->
                <div class="space-y-2">
                    <label for="title-input" class="text-xs font-semibold text-slate-300">Judul Halaman</label>
                    <input type="text" name="title" id="title-input" required
                        placeholder="Contoh: Tentang Kami, Syarat & Ketentuan"
                        class="w-full bg-white/5 border border-white/10 focus:border-brand-primary/40 rounded-2xl py-3.5 px-4 text-sm text-white placeholder-slate-500 outline-none transition-all duration-300">
                </div>

                <!-- Status Selector -->
                <div class="space-y-2">
                    <label for="status-select" class="text-xs font-semibold text-slate-300">Status Publikasi</label>
                    <div class="relative">
                        <select name="status" id="status-select"
                            class="w-full bg-white/5 border border-white/10 focus:border-brand-primary/40 rounded-2xl py-3.5 px-4 text-sm text-white focus:outline-none transition-all duration-300 appearance-none cursor-pointer">
                            <option value="draft" class="bg-dark-surface text-white">Draft (Hanya Admin/Editor yang
                                dapat melihat)</option>
                            <option value="published" class="bg-dark-surface text-white">Published (Terbuka untuk
                                Publik)</option>
                        </select>
                        <i data-lucide="chevron-down"
                            class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500 pointer-events-none"></i>
                    </div>
                </div>
            </div>

            <!-- URL Slug -->
            <div class="space-y-2">
                <label for="slug-input" class="text-xs font-semibold text-slate-300">URL Slug (Opsional)</label>
                <div class="flex items-center">
                    <span
                        class="bg-white/5 border border-r-0 border-white/10 rounded-l-2xl py-3.5 px-4 text-sm text-slate-500 font-mono">/p/</span>
                    <input type="text" name="slug" id="slug-input"
                        placeholder="tentang-kami (biarkan kosong untuk auto-generate dari judul)"
                        class="w-full bg-white/5 border border-white/10 focus:border-brand-primary/40 rounded-r-2xl py-3.5 px-4 text-sm text-white placeholder-slate-500 outline-none transition-all duration-300 font-mono">
                </div>
                <p class="text-[10px] text-slate-500 mt-1 leading-relaxed">Hanya gunakan huruf kecil, angka, dan tanda
                    hubung (-). Contoh: tentang-kami.</p>
            </div>

            <!-- Page Content -->
            <div class="space-y-2">
                <label for="content-input" class="text-xs font-semibold text-slate-300">Konten Halaman</label>
                <textarea name="content" id="content-input" rows="10" required placeholder="Tulis konten halaman di sini..." class="w-full bg-white/5 border border-white/10 focus:border-brand-primary/40 rounded-2xl py-3.5 px-4 text-sm text-white placeholder-slate-500 outline-none transition-all duration-300"></textarea>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 flex items-center justify-end space-x-4 border-t border-white/5">
                <a href="<?= route('/pages') ?>"
                    class="px-6 py-3 rounded-full text-xs font-bold text-slate-400 border border-white/5 hover:bg-white/5 hover:text-white transition-all">
                    Batal
                </a>

                <button type="submit"
                    class="px-8 py-3.5 rounded-full font-bold text-dark-bg bg-brand-primary hover:bg-white hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 shadow-lg shadow-brand-primary/20 flex items-center space-x-2 text-xs">
                    <span>Simpan Halaman</span>
                    <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                </button>
            </div>

        </form>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>