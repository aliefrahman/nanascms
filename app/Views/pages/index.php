<?php include __DIR__ . '/../layout/header.php'; ?>

<!-- Pages Manager Container -->
<div class="max-w-7xl mx-auto px-6 mt-10 relative z-10 pb-12 font-sans">
    <!-- Ambient background blobs -->
    <div class="blur-blob w-100 h-100 bg-brand-primary/5 -top-10 -left-10 animate-pulse-slow"></div>
    <div class="blur-blob w-100 h-100 bg-brand-emerald/5 bottom-10 right-10 animate-float-slow"></div>

    <!-- Page Title / Breadcrumb -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="font-display font-extrabold text-3xl text-white">Manajemen Halaman</h1>
            <p class="text-xs text-slate-500 mt-1">Buat, perbarui, atau kelola konten halaman statis website Anda.</p>
        </div>

        <a href="<?= route('/pages/create') ?>"
            class="inline-flex items-center justify-center px-5 py-3.5 rounded-full text-xs font-semibold text-dark-bg bg-brand-primary hover:bg-white hover:scale-105 active:scale-95 transition-all shadow-lg shadow-brand-primary/20">
            <i data-lucide="plus-circle" class="w-4 h-4 mr-2"></i>
            <span>Tambah Halaman</span>
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

    <?php if (isset($_SESSION['flash_success'])): ?>
        <div
            class="mb-6 p-4 rounded-xl border border-emerald-500/20 bg-emerald-500/10 text-emerald-400 text-xs flex items-start space-x-2">
            <i data-lucide="check-circle" class="w-4 h-4 shrink-0 mt-0.5"></i>
            <span><?= $_SESSION['flash_success'];
            unset($_SESSION['flash_success']); ?></span>
        </div>
    <?php endif; ?>

    <!-- Table Card -->
    <div class="glass-card rounded-3xl border border-white/5 overflow-hidden">
        <div class="overflow-x-auto">
            <?php if (empty($pages)): ?>
                <div class="py-20 flex flex-col items-center justify-center text-center">
                    <div class="w-16 h-16 rounded-2xl bg-white/5 flex items-center justify-center text-slate-600 mb-4">
                        <i data-lucide="file-text" class="w-8 h-8"></i>
                    </div>
                    <h4 class="font-display font-bold text-white">Belum Ada Halaman</h4>
                    <p class="text-xs text-slate-500 mt-1">Tambahkan halaman statis pertama Anda untuk memulainya.</p>
                </div>
            <?php else: ?>
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr
                            class="bg-white/2 border-b border-white/5 text-slate-400 text-xs font-semibold uppercase tracking-wider">
                            <th class="px-8 py-4">ID</th>
                            <th class="px-6 py-4">Judul Halaman</th>
                            <th class="px-6 py-4">Slug / URL</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Dibuat Pada</th>
                            <th class="px-8 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-slate-300 font-sans">
                        <?php foreach ($pages as $p): ?>
                            <tr class="hover:bg-white/1 transition-colors">
                                <td class="px-8 py-5 font-mono text-xs text-slate-500"><?= $p['id'] ?></td>
                                <td class="px-6 py-5 font-semibold text-white">
                                    <?= htmlspecialchars($p['title']) ?>
                                </td>
                                <td class="px-6 py-5 font-mono text-xs text-brand-primary">
                                    <?php if ($p['status'] === 'published'): ?>
                                        <a href="<?= route('/p/' . $p['slug']) ?>" target="_blank"
                                            class="hover:underline flex items-center space-x-1">
                                            <span>/p/<?= htmlspecialchars($p['slug']) ?></span>
                                            <i data-lucide="external-link" class="w-3 h-3"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-slate-500">/p/<?= htmlspecialchars($p['slug']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-5 text-xs">
                                    <?php if ($p['status'] === 'published'): ?>
                                        <span
                                            class="px-2.5 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 font-semibold uppercase tracking-wider text-[10px]">
                                            Published
                                        </span>
                                    <?php else: ?>
                                        <span
                                            class="px-2.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 font-semibold uppercase tracking-wider text-[10px]">
                                            Draft
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-5 font-mono text-xs text-slate-400">
                                    <?= date('d M Y, H:i', strtotime($p['created_at'])) ?>
                                </td>
                                <td class="px-8 py-5 text-right space-x-2">
                                    <a href="<?= route('/pages/edit?id=' . $p['id']) ?>"
                                        class="inline-flex p-2 rounded-lg border border-white/5 hover:border-brand-primary/30 bg-white/5 hover:bg-brand-primary/10 text-slate-400 hover:text-brand-primary transition-colors"
                                        title="Edit">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>

                                    <a href="<?= route('/pages/delete?id=' . $p['id']) ?>"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus halaman ini?');"
                                        class="inline-flex p-2 rounded-lg border border-white/5 hover:border-red-500/30 bg-white/5 hover:bg-red-500/10 text-slate-400 hover:text-red-400 transition-colors"
                                        title="Hapus">
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