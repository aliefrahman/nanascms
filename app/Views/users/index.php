<?php include __DIR__ . '/../layout/header.php'; ?>

<!-- Main Container -->
<div class="max-w-7xl mx-auto px-6 mt-10 relative z-10 pb-12">
        <!-- Breadcrumb / Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h1 class="font-display font-extrabold text-3xl text-white">Manajemen Pengguna</h1>
                <p class="text-xs text-slate-500 mt-1">Buat, perbarui, dan hapus user yang memiliki akses ke sistem.</p>
            </div>
            
            <a href="<?= route('/users/create') ?>" class="inline-flex items-center justify-center px-5 py-3 rounded-xl text-xs font-semibold text-dark-bg bg-brand-primary hover:bg-white hover:scale-105 active:scale-95 transition-all shadow-lg shadow-brand-primary/20">
                <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i>
                <span>Tambah Pengguna</span>
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
        <div class="glass-card rounded-4xl border border-white/5 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-white/2 border-b border-white/5 text-slate-400 text-xs font-semibold uppercase tracking-wider">
                            <th class="px-8 py-4">ID</th>
                            <th class="px-6 py-4">Avatar</th>
                            <th class="px-6 py-4">Nama Lengkap / Username</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Peran (Role)</th>
                            <th class="px-6 py-4">Tanggal Bergabung</th>
                            <th class="px-8 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-slate-300">
                        <?php foreach ($users as $u): 
                            $uName = !empty($u['fullname']) ? $u['fullname'] : '-';
                            $uAvatar = !empty($u['avatar']) ? $u['avatar'] : null;
                            $uInitials = strtoupper(substr(!empty($u['fullname']) ? $u['fullname'] : $u['username'], 0, 1));
                        ?>
                            <tr class="hover:bg-white/1 transition-colors">
                                <td class="px-8 py-5 font-mono text-xs text-slate-500"><?= $u['id'] ?></td>
                                <td class="px-6 py-5">
                                    <?php if ($uAvatar): ?>
                                        <img src="<?= htmlspecialchars($uAvatar) ?>" alt="Avatar" class="w-8 h-8 rounded-full object-cover border border-white/10">
                                    <?php else: ?>
                                        <div class="w-8 h-8 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 font-bold text-xs">
                                            <?= $uInitials ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="font-semibold text-white"><?= htmlspecialchars($uName) ?></div>
                                    <div class="text-xs text-slate-500">@<?= htmlspecialchars($u['username']) ?></div>
                                </td>
                                <td class="px-6 py-5 text-slate-400"><?= htmlspecialchars($u['email']) ?></td>
                                <td class="px-6 py-5">
                                    <?php 
                                        $badgeClass = 'bg-slate-500/10 text-slate-400 border-slate-500/20';
                                        if (strtolower($u['role_name']) === 'admin') $badgeClass = 'bg-brand-primary/10 text-brand-primary border-brand-primary/20';
                                        if (strtolower($u['role_name']) === 'editor') $badgeClass = 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20';
                                        if (strtolower($u['role_name']) === 'author') $badgeClass = 'bg-blue-500/10 text-blue-400 border-blue-500/20';
                                    ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border <?= $badgeClass ?> uppercase tracking-wider text-[10px]">
                                        <?= htmlspecialchars($u['role_name']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-slate-500 text-xs"><?= date('d M Y, H:i', strtotime($u['created_at'])) ?></td>
                                <td class="px-8 py-5 text-right space-x-2">
                                    <a href="<?= route('/users/edit?id=' . $u['id']) ?>" class="inline-flex p-2 rounded-lg border border-white/5 hover:border-brand-primary/30 bg-white/5 hover:bg-brand-primary/10 text-slate-400 hover:text-brand-primary transition-colors" title="Edit">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>
                                    
                                    <a href="<?= route('/users/delete?id=' . $u['id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?');" class="inline-flex p-2 rounded-lg border border-white/5 hover:border-red-500/30 bg-white/5 hover:bg-red-500/10 text-slate-400 hover:text-red-400 transition-colors" title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
