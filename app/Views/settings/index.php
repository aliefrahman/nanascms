<?php include __DIR__ . '/../layout/header.php'; ?>

<!-- Main Container -->
<div class="max-w-7xl mx-auto px-6 mt-10 relative z-10 pb-12">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <div class="flex items-center space-x-3 mb-1">
                <div
                    class="w-9 h-9 rounded-xl bg-brand-primary/10 border border-brand-primary/20 flex items-center justify-center">
                    <i data-lucide="settings-2" class="w-4 h-4 text-brand-primary"></i>
                </div>
                <h1 class="font-display font-extrabold text-3xl text-white">Pengaturan Sistem</h1>
            </div>
            <p class="text-xs text-slate-500 mt-1 ml-12">Kelola informasi profil dan kontak utama perusahaan.</p>
        </div>
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

    <!-- Form Settings -->
    <div class="glass-card rounded-3xl border border-white/5 overflow-hidden">
        <form action="<?= route('/settings/update') ?>" method="POST" enctype="multipart/form-data">
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="brand_name" class="block text-sm font-bold text-white tracking-wide mb-2">Nama
                        Brand</label>
                    <input type="text" id="brand_name" name="brand_name"
                        value="<?= htmlspecialchars($settings['brand_name'] ?? '') ?>"
                        class="w-full px-4 py-3 rounded-xl bg-dark-bg border border-white/10 text-slate-200 text-sm focus:outline-none focus:border-brand-primary/50 transition-all">
                </div>

                <div class="md:col-span-2">
                    <label for="company_name" class="block text-sm font-bold text-white tracking-wide mb-2">Nama
                        Perusahaan</label>
                    <input type="text" id="company_name" name="company_name"
                        value="<?= htmlspecialchars($settings['company_name'] ?? '') ?>"
                        class="w-full px-4 py-3 rounded-xl bg-dark-bg border border-white/10 text-slate-200 text-sm focus:outline-none focus:border-brand-primary/50 transition-all">
                </div>

                <div class="md:col-span-2">
                    <label for="tagline" class="block text-sm font-bold text-white tracking-wide mb-2">Tagline
                        (Slogan)</label>
                    <input type="text" id="tagline" name="tagline"
                        value="<?= htmlspecialchars($settings['tagline'] ?? '') ?>"
                        class="w-full px-4 py-3 rounded-xl bg-dark-bg border border-white/10 text-slate-200 text-sm focus:outline-none focus:border-brand-primary/50 transition-all"
                        placeholder="Contoh: Digital Creative Agency">
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-bold text-white tracking-wide mb-2">Deskripsi
                        Perusahaan</label>
                    <textarea id="description" name="description" rows="4"
                        class="w-full px-4 py-3 rounded-xl bg-dark-bg border border-white/10 text-slate-200 text-sm focus:outline-none focus:border-brand-primary/50 transition-all resize-none"
                        placeholder="Ceritakan singkat tentang perusahaan..."><?= htmlspecialchars($settings['description'] ?? '') ?></textarea>
                </div>

                <div>
                    <label for="company_email" class="block text-sm font-bold text-white tracking-wide mb-2">Email
                        Perusahaan</label>
                    <input type="email" id="company_email" name="company_email"
                        value="<?= htmlspecialchars($settings['company_email'] ?? '') ?>"
                        class="w-full px-4 py-3 rounded-xl bg-dark-bg border border-white/10 text-slate-200 text-sm focus:outline-none focus:border-brand-primary/50 transition-all">
                </div>

                <div>
                    <label for="contact_number" class="block text-sm font-bold text-white tracking-wide mb-2">Nomor
                        Kontak</label>
                    <input type="text" id="contact_number" name="contact_number"
                        value="<?= htmlspecialchars($settings['contact_number'] ?? '') ?>"
                        class="w-full px-4 py-3 rounded-xl bg-dark-bg border border-white/10 text-slate-200 text-sm focus:outline-none focus:border-brand-primary/50 transition-all">
                </div>

                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-bold text-white tracking-wide mb-2">Alamat
                        Lengkap</label>
                    <textarea id="address" name="address" rows="3"
                        class="w-full px-4 py-3 rounded-xl bg-dark-bg border border-white/10 text-slate-200 text-sm focus:outline-none focus:border-brand-primary/50 transition-all resize-none"><?= htmlspecialchars($settings['address'] ?? '') ?></textarea>
                </div>

                <div>
                    <label for="latitude" class="block text-sm font-bold text-white tracking-wide mb-2">Latitude (Garis
                        Lintang)</label>
                    <input type="text" id="latitude" name="latitude"
                        value="<?= htmlspecialchars($settings['latitude'] ?? '') ?>"
                        class="w-full px-4 py-3 rounded-xl bg-dark-bg border border-white/10 text-slate-200 text-sm focus:outline-none focus:border-brand-primary/50 transition-all">
                </div>

                <div>
                    <label for="longitude" class="block text-sm font-bold text-white tracking-wide mb-2">Longitude
                        (Garis Bujur)</label>
                    <input type="text" id="longitude" name="longitude"
                        value="<?= htmlspecialchars($settings['longitude'] ?? '') ?>"
                        class="w-full px-4 py-3 rounded-xl bg-dark-bg border border-white/10 text-slate-200 text-sm focus:outline-none focus:border-brand-primary/50 transition-all">
                </div>
                <div class="md:col-span-2">
                    <label for="logo" class="block text-sm font-bold text-white tracking-wide mb-2">Logo
                        Perusahaan</label>
                    <?php if (!empty($settings['logo'])): ?>
                        <div class="mb-3">
                            <img src="<?= route($settings['logo']) ?>" alt="Logo Perusahaan"
                                class="h-16 object-contain rounded-lg bg-white/5 p-2 border border-white/10">
                        </div>
                    <?php endif; ?>
                    <input type="file" id="logo" name="logo" accept="image/*"
                        class="w-full px-4 py-3 rounded-xl bg-dark-bg border border-white/10 text-slate-200 text-sm focus:outline-none focus:border-brand-primary/50 transition-all file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-brand-primary/10 file:text-brand-primary hover:file:bg-brand-primary/20">
                    <p class="mt-1.5 text-xs text-slate-500">Biarkan kosong jika tidak ingin mengubah logo saat ini.
                        (Maks. 2MB)</p>
                </div>
            </div>

            <div class="p-6 border-t border-white/5 bg-white/5 flex items-center justify-end space-x-3">
                <button type="reset"
                    class="inline-flex items-center px-5 py-3 rounded-xl text-xs font-semibold text-slate-400 hover:text-white hover:bg-white/10 transition-all">
                    Batal
                </button>
                <button type="submit"
                    class="inline-flex items-center px-6 py-3 rounded-xl text-xs font-semibold text-dark-bg bg-brand-primary hover:bg-white hover:scale-105 active:scale-95 transition-all shadow-lg shadow-brand-primary/20">
                    <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>