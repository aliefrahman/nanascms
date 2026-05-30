<?php include __DIR__ . '/../layout/header.php'; ?>

<!-- Menus Edit Container -->
<div class="max-w-3xl mx-auto px-6 mt-10 relative z-10 pb-12 font-sans">
    <!-- Ambient background blobs -->
    <div class="blur-blob w-100 h-100 bg-brand-primary/5 -top-10 -left-10 animate-pulse-slow"></div>

    <!-- Page Title / Breadcrumb -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="font-display font-extrabold text-3xl text-white">Edit Menu</h1>
            <p class="text-xs text-slate-500 mt-1">Perbarui detail link navigasi menu utama atau sub-menu.</p>
        </div>
        
        <a href="<?= route('/menus') ?>" class="inline-flex items-center text-xs font-semibold text-slate-400 hover:text-brand-primary transition-colors group">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform"></i>
            <span>Kembali ke Menu</span>
        </a>
    </div>

    <!-- Flash Session Alerts -->
    <?php if (isset($_SESSION['flash_error'])): ?>
        <div class="mb-6 p-4 rounded-xl border border-red-500/20 bg-red-500/10 text-red-400 text-xs flex items-start space-x-2">
            <i data-lucide="alert-circle" class="w-4 h-4 shrink-0 mt-0.5"></i>
            <span><?= $_SESSION['flash_error']; unset($_SESSION['flash_error']); ?></span>
        </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="glass-card p-8 rounded-3xl border border-white/5">
        <form action="<?= route('/menus/update') ?>" method="POST" class="space-y-6">
            <input type="hidden" name="id" value="<?= (int)$currentMenu['id'] ?>">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Menu Title -->
                <div class="space-y-2">
                    <label for="title-input" class="text-xs font-semibold text-slate-300">Judul Menu</label>
                    <input type="text" 
                           name="title" 
                           id="title-input" 
                           value="<?= htmlspecialchars($currentMenu['title'] ?? '') ?>"
                           required 
                           placeholder="Contoh: Layanan, Portofolio" 
                           class="w-full bg-white/5 border border-white/10 focus:border-brand-primary/40 rounded-2xl py-3.5 px-4 text-sm text-white placeholder-slate-500 outline-none transition-all duration-300">
                </div>

                <!-- Sort Order -->
                <div class="space-y-2">
                    <label for="sort-input" class="text-xs font-semibold text-slate-300">Urutan Tampilan</label>
                    <input type="number" 
                           name="sort_order" 
                           id="sort-input" 
                           value="<?= (int)$currentMenu['sort_order'] ?>" 
                           min="0"
                           required 
                           placeholder="Contoh: 1, 2, 3" 
                           class="w-full bg-white/5 border border-white/10 focus:border-brand-primary/40 rounded-2xl py-3.5 px-4 text-sm text-white placeholder-slate-500 outline-none transition-all duration-300">
                </div>
            </div>

            <!-- URL / Link -->
            <div class="space-y-2">
                <label for="url-input" class="text-xs font-semibold text-slate-300">URL / Link Target</label>
                <input type="text" 
                       name="url" 
                       id="url-input" 
                       value="<?= htmlspecialchars($currentMenu['url'] ?? '') ?>"
                       required 
                       placeholder="Contoh: /#services, /contact, atau http://external-link.com" 
                       class="w-full bg-white/5 border border-white/10 focus:border-brand-primary/40 rounded-2xl py-3.5 px-4 text-sm text-white placeholder-slate-500 outline-none transition-all duration-300 font-mono">
            </div>

            <!-- Parent Menu Selector -->
            <div class="space-y-2">
                <label for="parent-select" class="text-xs font-semibold text-slate-300">Parent Menu (Sub-menu Dari)</label>
                <div class="relative">
                    <?php if ($hasChildren): ?>
                        <select name="parent_id" 
                                id="parent-select" 
                                disabled
                                class="w-full bg-white/5 border border-white/10 opacity-60 rounded-2xl py-3.5 px-4 text-sm text-slate-400 focus:outline-none appearance-none cursor-not-allowed">
                            <option value="root" selected>Tidak Ada / Root (Menu Utama) - Memiliki Sub-menu</option>
                        </select>
                        <input type="hidden" name="parent_id" value="root">
                    <?php else: ?>
                        <select name="parent_id" 
                                id="parent-select" 
                                class="w-full bg-white/5 border border-white/10 focus:border-brand-primary/40 rounded-2xl py-3.5 px-4 text-sm text-white focus:outline-none transition-all duration-300 appearance-none cursor-pointer">
                            <option value="root" class="bg-dark-surface text-slate-300" <?= !$currentMenu['parent_id'] ? 'selected' : '' ?>>Tidak Ada / Root (Menu Utama)</option>
                            <?php foreach ($menus as $m): ?>
                                <?php if (!$m['parent_id']): ?>
                                    <option value="<?= $m['id'] ?>" class="bg-dark-surface text-white" <?= (int)$m['id'] === (int)$currentMenu['parent_id'] ? 'selected' : '' ?>><?= htmlspecialchars($m['title'] ?? '') ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500 pointer-events-none"></i>
                    <?php endif; ?>
                </div>
                <p class="text-[10px] text-slate-500 mt-1 leading-relaxed">
                    <?php if ($hasChildren): ?>
                        Menu ini memiliki sub-menu (dropdown) aktif, sehingga tidak dapat dijadikan sub-menu dari menu lain.
                    <?php else: ?>
                        Pilih menu utama jika link ini merupakan bagian dropdown dari menu tersebut. Pilih "Tidak Ada / Root" untuk menjadikannya menu utama.
                    <?php endif; ?>
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 flex items-center justify-end space-x-4 border-t border-white/5">
                <a href="<?= route('/menus') ?>" class="px-6 py-3 rounded-full text-xs font-bold text-slate-400 border border-white/5 hover:bg-white/5 hover:text-white transition-all">
                    Batal
                </a>
                
                <button type="submit" class="px-8 py-3.5 rounded-full font-bold text-dark-bg bg-brand-primary hover:bg-white hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 shadow-lg shadow-brand-primary/20 flex items-center space-x-2 text-xs">
                    <span>Simpan Perubahan</span>
                    <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                </button>
            </div>

        </form>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
