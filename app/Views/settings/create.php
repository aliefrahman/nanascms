<?php include __DIR__ . '/../layout/header.php'; ?>

<!-- Main Container -->
<div class="max-w-3xl mx-auto px-6 mt-10 pb-16 relative z-10">

    <!-- Back + Page Header -->
    <div class="flex items-center space-x-3 mb-8">
        <a href="<?= route('/settings') ?>"
            class="p-2 rounded-lg border border-white/10 bg-white/5 text-slate-400 hover:text-white hover:border-white/20 transition-all">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <div>
            <h1 class="font-display font-extrabold text-2xl text-white">Tambah Pengaturan</h1>
            <p class="text-xs text-slate-500 mt-0.5">Daftarkan kunci dan nilai konfigurasi baru.</p>
        </div>
    </div>

    <!-- Flash Error -->
    <?php if (isset($_SESSION['flash_error'])): ?>
        <div
            class="mb-6 p-4 rounded-xl border border-red-500/20 bg-red-500/10 text-red-400 text-xs flex items-start space-x-2">
            <i data-lucide="alert-circle" class="w-4 h-4 shrink-0 mt-0.5"></i>
            <span><?= $_SESSION['flash_error'];
            unset($_SESSION['flash_error']); ?></span>
        </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="glass-card rounded-3xl border border-white/5 p-8">
        <form action="<?= route('/settings/store') ?>" method="POST" id="settings-create-form" novalidate>

            <!-- Setting Key -->
            <div class="mb-6">
                <label for="setting_key"
                    class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">
                    Kunci (Key) <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <i data-lucide="key-round"
                        class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"></i>
                    <input type="text" id="setting_key" name="setting_key"
                        value="<?= htmlspecialchars($_POST['setting_key'] ?? '') ?>"
                        placeholder="contoh: site_name, company_email" required pattern="[a-zA-Z0-9_\.]+"
                        autocomplete="off"
                        class="w-full pl-10 pr-4 py-3 rounded-xl bg-white/5 border border-white/10 text-slate-100 text-sm placeholder:text-slate-600 focus:outline-none focus:border-brand-primary/50 focus:bg-white/8 transition-all font-mono">
                </div>
                <p class="mt-1.5 text-xs text-slate-600">Hanya huruf, angka, underscore (<code
                        class="text-slate-500">_</code>), dan titik (<code class="text-slate-500">.</code>).</p>
            </div>

            <!-- Setting Value -->
            <div class="mb-8">
                <label for="value" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">
                    Nilai (Value)
                </label>
                <textarea id="value" name="value" rows="4" placeholder="Masukkan nilai untuk kunci di atas..."
                    class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-slate-100 text-sm placeholder:text-slate-600 focus:outline-none focus:border-brand-primary/50 focus:bg-white/8 transition-all resize-none font-mono leading-relaxed"><?= htmlspecialchars($_POST['value'] ?? '') ?></textarea>
                <p class="mt-1.5 text-xs text-slate-600">Kosongkan jika belum ada nilai. Nilai akan disimpan sebagai
                    NULL.</p>
            </div>

            <!-- Setting Description -->
            <div class="mb-8">
                <label for="description"
                    class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">
                    Deskripsi (Opsional)
                </label>
                <input type="text" id="description" name="description"
                    value="<?= htmlspecialchars($_POST['description'] ?? '') ?>"
                    placeholder="Contoh: Pengaturan nama website di navbar..."
                    class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-slate-100 text-sm placeholder:text-slate-600 focus:outline-none focus:border-brand-primary/50 focus:bg-white/8 transition-all">
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-3">
                <a href="<?= route('/settings') ?>"
                    class="inline-flex items-center px-5 py-2.5 rounded-xl text-xs font-semibold text-slate-400 border border-white/10 bg-white/5 hover:bg-white/8 hover:text-white transition-all">
                    Batal
                </a>
                <button type="submit" id="btn-submit-create"
                    class="inline-flex items-center px-6 py-2.5 rounded-xl text-xs font-semibold text-dark-bg bg-brand-primary hover:bg-white hover:scale-105 active:scale-95 transition-all shadow-lg shadow-brand-primary/20">
                    <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
                </button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
