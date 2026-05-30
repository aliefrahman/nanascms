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
            <h1 class="font-display font-extrabold text-2xl text-white">Edit Pengaturan</h1>
            <p class="text-xs text-slate-500 mt-0.5">
                Perbarui kunci &amp; nilai untuk
                <code class="text-brand-primary font-mono text-xs bg-brand-primary/8 px-1.5 py-0.5 rounded">
                    <?= htmlspecialchars($setting['setting_key']) ?>
                </code>
            </p>
        </div>
    </div>

    <!-- Flash Error -->
    <?php if (isset($_SESSION['flash_error'])): ?>
        <div class="mb-6 p-4 rounded-xl border border-red-500/20 bg-red-500/10 text-red-400 text-xs flex items-start space-x-2">
            <i data-lucide="alert-circle" class="w-4 h-4 shrink-0 mt-0.5"></i>
            <span><?= $_SESSION['flash_error']; unset($_SESSION['flash_error']); ?></span>
        </div>
    <?php endif; ?>

    <!-- Meta Info Strip -->
    <div class="mb-5 flex flex-wrap gap-3">
        <div class="flex items-center space-x-2 px-3 py-1.5 rounded-lg bg-white/5 border border-white/8 text-xs text-slate-500">
            <i data-lucide="hash" class="w-3.5 h-3.5"></i>
            <span>ID: <span class="text-slate-400 font-mono"><?= $setting['id'] ?></span></span>
        </div>
        <?php if (!empty($setting['updated_at'])): ?>
        <div class="flex items-center space-x-2 px-3 py-1.5 rounded-lg bg-white/5 border border-white/8 text-xs text-slate-500">
            <i data-lucide="clock" class="w-3.5 h-3.5"></i>
            <span>Diperbarui: <span class="text-slate-400"><?= date('d M Y, H:i', strtotime($setting['updated_at'])) ?></span></span>
        </div>
        <?php endif; ?>
    </div>

    <!-- Form Card -->
    <div class="glass-card rounded-3xl border border-white/5 p-8">
        <form action="<?= route('/settings/update') ?>" method="POST" id="settings-edit-form" novalidate>
            <input type="hidden" name="id" value="<?= $setting['id'] ?>">

            <!-- Setting Key -->
            <div class="mb-6">
                <label for="setting_key" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">
                    Kunci (Key) <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <i data-lucide="key-round" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"></i>
                    <input
                        type="text"
                        id="setting_key"
                        name="setting_key"
                        value="<?= htmlspecialchars($_POST['setting_key'] ?? $setting['setting_key']) ?>"
                        required
                        pattern="[a-zA-Z0-9_\.]+"
                        autocomplete="off"
                        class="w-full pl-10 pr-4 py-3 rounded-xl bg-white/5 border border-white/10 text-slate-100 text-sm placeholder:text-slate-600 focus:outline-none focus:border-brand-primary/50 focus:bg-white/8 transition-all font-mono">
                </div>
                <p class="mt-1.5 text-xs text-slate-600">Hanya huruf, angka, underscore (<code class="text-slate-500">_</code>), dan titik (<code class="text-slate-500">.</code>).</p>
            </div>

            <!-- Setting Value -->
            <div class="mb-8">
                <label for="value" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">
                    Nilai (Value)
                </label>
                <textarea
                    id="value"
                    name="value"
                    rows="4"
                    placeholder="Masukkan nilai pengaturan..."
                    class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-slate-100 text-sm placeholder:text-slate-600 focus:outline-none focus:border-brand-primary/50 focus:bg-white/8 transition-all resize-none font-mono leading-relaxed"><?= htmlspecialchars($_POST['value'] ?? $setting['value'] ?? '') ?></textarea>
                <p class="mt-1.5 text-xs text-slate-600">Kosongkan untuk menyimpan sebagai NULL.</p>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between">
                <!-- Danger Zone -->
                <a href="<?= route('/settings/delete?id=' . $setting['id']) ?>"
                   id="btn-delete-setting-<?= $setting['id'] ?>"
                   onclick="return confirm('Apakah Anda yakin ingin menghapus pengaturan ini?');"
                   class="inline-flex items-center px-4 py-2.5 rounded-xl text-xs font-semibold text-red-400 border border-red-500/20 bg-red-500/5 hover:bg-red-500/10 hover:border-red-500/30 transition-all">
                    <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i>
                    Hapus
                </a>

                <div class="flex items-center space-x-3">
                    <a href="<?= route('/settings') ?>"
                       class="inline-flex items-center px-5 py-2.5 rounded-xl text-xs font-semibold text-slate-400 border border-white/10 bg-white/5 hover:bg-white/8 hover:text-white transition-all">
                        Batal
                    </a>
                    <button
                        type="submit"
                        id="btn-submit-edit"
                        class="inline-flex items-center px-6 py-2.5 rounded-xl text-xs font-semibold text-dark-bg bg-brand-primary hover:bg-white hover:scale-105 active:scale-95 transition-all shadow-lg shadow-brand-primary/20">
                        <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                        Perbarui Pengaturan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
