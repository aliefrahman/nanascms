<?php include __DIR__ . '/../layout/header.php'; ?>

<!-- Menus Manager Container -->
<div class="max-w-7xl mx-auto px-6 mt-10 relative z-10 pb-12 font-sans">
    <!-- Ambient background blobs -->
    <div class="blur-blob w-100 h-100 bg-brand-primary/5 -top-10 -left-10 animate-pulse-slow"></div>
    <div class="blur-blob w-100 h-100 bg-brand-emerald/5 bottom-10 right-10 animate-float-slow"></div>

    <!-- Page Title / Breadcrumb -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="font-display font-extrabold text-3xl text-white">Manajemen Menu</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola link navigasi menu utama, drop-down submenu, dan urutan posisinya di website.</p>
        </div>
        
        <a href="<?= route('/menus/create') ?>" class="inline-flex items-center justify-center px-5 py-3.5 rounded-full text-xs font-semibold text-dark-bg bg-brand-primary hover:bg-white hover:scale-105 active:scale-95 transition-all shadow-lg shadow-brand-primary/20">
            <i data-lucide="plus-circle" class="w-4 h-4 mr-2"></i>
            <span>Tambah Menu</span>
        </a>
    </div>

    <!-- Flash Session Alerts -->
    <?php if (isset($_SESSION['flash_error'])): ?>
        <div class="mb-6 p-4 rounded-xl border border-red-500/20 bg-red-500/10 text-red-400 text-xs flex items-start space-x-2">
            <i data-lucide="alert-circle" class="w-4 h-4 shrink-0 mt-0.5"></i>
            <span><?= $_SESSION['flash_error']; unset($_SESSION['flash_error']); ?></span>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['flash_success'])): ?>
        <div class="mb-6 p-4 rounded-xl border border-emerald-500/20 bg-emerald-500/10 text-emerald-400 text-xs flex items-start space-x-2">
            <i data-lucide="check-circle" class="w-4 h-4 shrink-0 mt-0.5"></i>
            <span><?= $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?></span>
        </div>
    <?php endif; ?>

    <!-- Table Card -->
    <div class="glass-card rounded-3xl border border-white/5 overflow-hidden">
        <div class="overflow-x-auto">
            <?php if (empty($menus)): ?>
                <div class="py-20 flex flex-col items-center justify-center text-center">
                    <div class="w-16 h-16 rounded-2xl bg-white/5 flex items-center justify-center text-slate-600 mb-4">
                        <i data-lucide="menu" class="w-8 h-8"></i>
                    </div>
                    <h4 class="font-display font-bold text-white">Belum Ada Menu</h4>
                    <p class="text-xs text-slate-500 mt-1">Tambahkan link menu navigasi pertama Anda untuk memulainya.</p>
                </div>
            <?php else: ?>
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-white/2 border-b border-white/5 text-slate-400 text-xs font-semibold uppercase tracking-wider">
                            <th class="px-8 py-4">ID</th>
                            <th class="px-6 py-4">Judul Menu</th>
                            <th class="px-6 py-4">URL / Link</th>
                            <th class="px-6 py-4">Parent Menu</th>
                            <th class="px-6 py-4">Urutan</th>
                            <th class="px-8 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-slate-300 font-sans">
                        <?php foreach ($menus as $m): ?>
                            <tr class="hover:bg-white/1 transition-colors">
                                <td class="px-8 py-5 font-mono text-xs text-slate-500"><?= $m['id'] ?></td>
                                <td class="px-6 py-5 font-semibold text-white">
                                    <?php if ($m['parent_id']): ?>
                                        <span class="text-slate-500 font-light mr-1">—</span> 
                                    <?php endif; ?>
                                    <?= htmlspecialchars($m['title']) ?>
                                </td>
                                <td class="px-6 py-5 font-mono text-xs text-brand-primary">
                                    <?= htmlspecialchars($m['url']) ?>
                                </td>
                                <td class="px-6 py-5 text-xs">
                                    <?php if ($m['parent_title']): ?>
                                        <span class="px-2.5 py-1 rounded-md bg-white/5 border border-white/10 text-slate-400 font-medium">
                                            <?= htmlspecialchars($m['parent_title']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-slate-600 font-light italic">Root</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-5 font-mono text-xs text-slate-400">
                                    <?= (int)$m['sort_order'] ?>
                                </td>
                                <td class="px-8 py-5 text-right space-x-2">
                                    <a href="<?= route('/menus/edit?id=' . $m['id']) ?>" class="inline-flex p-2 rounded-lg border border-white/5 hover:border-brand-primary/30 bg-white/5 hover:bg-brand-primary/10 text-slate-400 hover:text-brand-primary transition-colors" title="Edit">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>
                                    
                                    <a href="<?= route('/menus/delete?id=' . $m['id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?');" class="inline-flex p-2 rounded-lg border border-white/5 hover:border-red-500/30 bg-white/5 hover:bg-red-500/10 text-slate-400 hover:text-red-400 transition-colors" title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
