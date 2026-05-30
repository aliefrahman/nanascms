<?php include __DIR__ . '/../layout/header.php'; ?>

<!-- Main Container -->
<div class="max-w-7xl mx-auto px-6 mt-10 relative z-10 pb-12">
        <!-- Greetings panel -->
        <div class="glass-card p-8 sm:p-10 rounded-3xl border border-white/5 relative overflow-hidden mb-10">
            <div class="absolute -top-12 -right-12 w-48 h-48 bg-brand-primary/5 rounded-full blur-3xl"></div>
            
            <div class="max-w-xl">
                <h1 class="font-display font-extrabold text-3xl sm:text-4xl text-white leading-tight">
                    Halo, <span class="text-gradient-nanas"><?= htmlspecialchars(!empty($user['fullname']) ? $user['fullname'] : $user['username']) ?></span>!
                </h1>
                <p class="text-sm text-slate-400 mt-2 font-light">
                    Anda masuk sebagai <strong class="text-white"><?= htmlspecialchars($user['role_name']) ?></strong>. Selamat mengelola portal kreatif Nanas Home Studio.
                </p>
            </div>
        </div>

        <?php if ($user['role_name'] === 'Admin'): ?>
            <!-- ADMIN VIEW PANEL -->
            
            <!-- Quick Analytics Counters -->
            <?php 
                $countAdmin = 0; $countEditor = 0; $countAuthor = 0; 
                foreach ($allUsers as $u) {
                    if (strtolower($u['role_name']) === 'admin') $countAdmin++;
                    if (strtolower($u['role_name']) === 'editor') $countEditor++;
                    if (strtolower($u['role_name']) === 'author') $countAuthor++;
                }
                $totalUsers = count($allUsers);
            ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <div class="glass-card p-6 rounded-2xl border border-white/5">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total User</span>
                        <div class="w-8 h-8 rounded-lg bg-brand-primary/10 text-brand-primary flex items-center justify-center">
                            <i data-lucide="users" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <h3 class="font-display font-extrabold text-3xl text-white"><?= $totalUsers ?></h3>
                </div>

                <div class="glass-card p-6 rounded-2xl border border-white/5">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Administrator</span>
                        <div class="w-8 h-8 rounded-lg bg-purple-500/10 text-purple-400 flex items-center justify-center">
                            <i data-lucide="shield-check" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <h3 class="font-display font-extrabold text-3xl text-white"><?= $countAdmin ?></h3>
                </div>

                <div class="glass-card p-6 rounded-2xl border border-white/5">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Editor Portal</span>
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center">
                            <i data-lucide="file-edit" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <h3 class="font-display font-extrabold text-3xl text-white"><?= $countEditor ?></h3>
                </div>

                <div class="glass-card p-6 rounded-2xl border border-white/5">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Author Konten</span>
                        <div class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-400 flex items-center justify-center">
                            <i data-lucide="user-cog" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <h3 class="font-display font-extrabold text-3xl text-white"><?= $countAuthor ?></h3>
                </div>
            </div>

            <!-- Admin Quick Actions / Menu -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <a href="<?= route('/users') ?>" class="glass-card p-6 rounded-2xl border border-white/5 hover:border-brand-primary/30 hover:bg-white/2 transition-all group flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-xl bg-brand-primary/10 text-brand-primary flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i data-lucide="users-cog" class="w-6 h-6 text-brand-primary"></i>
                    </div>
                    <div>
                        <h4 class="font-display font-bold text-white group-hover:text-brand-primary transition-colors text-sm sm:text-base">Manajemen User</h4>
                        <p class="text-[10px] sm:text-xs text-slate-500 mt-1">Kelola data & role pengguna.</p>
                    </div>
                </a>
                
                <a href="<?= route('/users/create') ?>" class="glass-card p-6 rounded-2xl border border-white/5 hover:border-brand-emerald/30 hover:bg-white/2 transition-all group flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-xl bg-brand-emerald/10 text-brand-emerald flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i data-lucide="user-plus" class="w-6 h-6 text-brand-emerald"></i>
                    </div>
                    <div>
                        <h4 class="font-display font-bold text-white group-hover:text-brand-emerald transition-colors text-sm sm:text-base">Tambah User</h4>
                        <p class="text-[10px] sm:text-xs text-slate-500 mt-1">Daftarkan akun baru.</p>
                    </div>
                </a>

                <a href="<?= route('/profile') ?>" class="glass-card p-6 rounded-2xl border border-white/5 hover:border-amber-400/30 hover:bg-white/2 transition-all group flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i data-lucide="user" class="w-6 h-6 text-amber-400"></i>
                    </div>
                    <div>
                        <h4 class="font-display font-bold text-white group-hover:text-amber-400 transition-colors text-sm sm:text-base">Edit Profil</h4>
                        <p class="text-[10px] sm:text-xs text-slate-500 mt-1">Ubah data personal & password.</p>
                    </div>
                </a>

                <div class="glass-card p-6 rounded-2xl border border-white/5 flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/10 text-purple-400 flex items-center justify-center">
                        <i data-lucide="database" class="w-6 h-6 text-purple-400"></i>
                    </div>
                    <div>
                        <h4 class="font-display font-bold text-white text-sm sm:text-base">Status Database</h4>
                        <p class="text-[10px] sm:text-xs text-slate-400 mt-1">Koneksi: nanascms_db</p>
                    </div>
                </div>
            </div>

            <!-- Users Management Table -->
            <div class="glass-card rounded-3xl border border-white/5 overflow-hidden">
                <div class="px-8 py-6 border-b border-white/5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h3 class="font-display font-bold text-lg text-white">Daftar Pengguna Sistem</h3>
                        <p class="text-xs text-slate-500 mt-1">Daftar seluruh user terdaftar beserta peran otorisasi.</p>
                    </div>
                    
                    <a href="<?= route('/users/create') ?>" class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-xs font-semibold text-dark-bg bg-brand-primary hover:bg-white transition-all shadow shadow-brand-primary/10">
                        <i data-lucide="plus" class="w-4 h-4 mr-1.5"></i>
                        <span>Tambah User Baru</span>
                    </a>
                </div>

                <?php if (isset($db_warning)): ?>
                    <div class="m-6 p-4 rounded-xl border border-yellow-500/20 bg-yellow-500/10 text-yellow-400 text-xs">
                        <?= $db_warning ?>
                    </div>
                <?php endif; ?>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="bg-white/2 border-b border-white/5 text-slate-400 text-xs font-semibold uppercase tracking-wider">
                                <th class="px-8 py-4">ID</th>
                                <th class="px-6 py-4">Avatar</th>
                                <th class="px-6 py-4">Nama Lengkap / Username</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4">Role</th>
                                <th class="px-6 py-4">Tanggal Registrasi</th>
                                <th class="px-8 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5 text-slate-300">
                            <?php foreach ($allUsers as $u): 
                                $uName = !empty($u['fullname']) ? $u['fullname'] : '-';
                                $uAvatar = !empty($u['avatar']) ? $u['avatar'] : null;
                                $uInitials = strtoupper(substr(!empty($u['fullname']) ? $u['fullname'] : $u['username'], 0, 1));
                            ?>
                                <tr class="hover:bg-white/1 transition-colors">
                                    <td class="px-8 py-4 font-mono text-xs text-slate-500"><?= $u['id'] ?></td>
                                    <td class="px-6 py-4">
                                        <?php if ($uAvatar): ?>
                                            <img src="<?= htmlspecialchars($uAvatar) ?>" alt="Avatar" class="w-8 h-8 rounded-full object-cover border border-white/10">
                                        <?php else: ?>
                                            <div class="w-8 h-8 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 font-bold text-xs">
                                                <?= $uInitials ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-white"><?= htmlspecialchars($uName) ?></div>
                                        <div class="text-xs text-slate-500">@<?= htmlspecialchars($u['username']) ?></div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-400"><?= htmlspecialchars($u['email']) ?></td>
                                    <td class="px-6 py-4">
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
                                    <td class="px-6 py-4 text-slate-500 text-xs"><?= date('d M Y, H:i', strtotime($u['created_at'])) ?></td>
                                    <td class="px-8 py-4 text-right space-x-2">
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

        <?php else: ?>
            <!-- NON-ADMIN VIEW PANEL (EDITOR / AUTHOR) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Profile details -->
                <div class="glass-card p-8 rounded-3xl border border-white/5 space-y-6">
                    <div class="flex flex-col items-center space-y-3 pb-4 border-b border-white/5">
                        <?php 
                            $uAvatar = !empty($user['avatar']) ? $user['avatar'] : null;
                            $uName = !empty($user['fullname']) ? $user['fullname'] : $user['username'];
                            $uInitials = strtoupper(substr($uName, 0, 1));
                        ?>
                        <?php if ($uAvatar): ?>
                            <img src="<?= htmlspecialchars($uAvatar) ?>" alt="Avatar" class="w-20 h-20 rounded-full object-cover border-2 border-brand-primary/40 shadow-lg">
                        <?php else: ?>
                            <div class="w-20 h-20 rounded-full bg-linear-to-tr from-brand-secondary to-brand-primary flex items-center justify-center text-dark-bg font-extrabold text-2xl shadow-lg">
                                <?= $uInitials ?>
                            </div>
                        <?php endif; ?>
                        <div class="text-center">
                            <h4 class="font-display font-bold text-white text-lg"><?= htmlspecialchars($uName) ?></h4>
                            <p class="text-xs text-slate-400">@<?= htmlspecialchars($user['username']) ?></p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="pb-4 border-b border-white/5">
                            <span class="text-xs text-slate-500 block uppercase tracking-wider font-semibold">Nama Lengkap</span>
                            <span class="text-white font-medium"><?= htmlspecialchars(!empty($user['fullname']) ? $user['fullname'] : 'Belum diatur') ?></span>
                        </div>
                        <div class="pb-4 border-b border-white/5">
                            <span class="text-xs text-slate-500 block uppercase tracking-wider font-semibold">Alamat Email</span>
                            <span class="text-white font-medium"><?= htmlspecialchars($user['email']) ?></span>
                        </div>
                        <div class="pb-4 border-b border-white/5">
                            <span class="text-xs text-slate-500 block uppercase tracking-wider font-semibold">Hak Akses</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-brand-emerald/10 text-brand-emerald border border-brand-emerald/20 mt-1 uppercase tracking-wide">
                                <?= htmlspecialchars($user['role_name']) ?>
                            </span>
                        </div>
                        <div>
                            <span class="text-xs text-slate-500 block uppercase tracking-wider font-semibold">Bergabung Sejak</span>
                            <span class="text-slate-400 text-xs"><?= date('d F Y, H:i', strtotime($user['created_at'])) ?></span>
                        </div>
                    </div>
                    
                    <div class="pt-2">
                        <a href="<?= route('/profile') ?>" class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs font-semibold text-white border border-white/10 hover:border-brand-primary/30 bg-white/5 hover:bg-brand-primary/10 transition-all font-sans">
                            <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i>
                            <span>Edit Profil Saya</span>
                        </a>
                    </div>
                </div>

                <!-- Role specific actions -->
                <div class="glass-card p-8 rounded-3xl border border-white/5 md:col-span-2 space-y-6">
                    <h3 class="font-display font-bold text-lg text-white">Panel Kerja <?= htmlspecialchars($user['role_name']) ?></h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <?php if (strtolower($user['role_name']) === 'editor'): ?>
                            <!-- Editor Workflow Cards -->
                            <div class="p-6 rounded-2xl border border-white/5 hover:border-brand-emerald/20 bg-white/1 transition-all group">
                                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center mb-4">
                                    <i data-lucide="check-square" class="w-5 h-5"></i>
                                </div>
                                <h4 class="font-display font-bold text-white mb-2 group-hover:text-brand-emerald transition-colors">Review Tulisan</h4>
                                <p class="text-xs text-slate-400 leading-relaxed font-light">Tinjau draft artikel dan beri persetujuan untuk dipublikasikan.</p>
                            </div>
                            
                            <div class="p-6 rounded-2xl border border-white/5 hover:border-brand-emerald/20 bg-white/1 transition-all group">
                                <div class="w-10 h-10 rounded-xl bg-brand-primary/10 text-brand-primary flex items-center justify-center mb-4">
                                    <i data-lucide="file-text" class="w-5 h-5"></i>
                                </div>
                                <h4 class="font-display font-bold text-white mb-2 group-hover:text-brand-primary transition-colors">Kelola Kategori</h4>
                                <p class="text-xs text-slate-400 leading-relaxed font-light">Buat, sunting, dan kelompokkan kategori tulisan di situs CMS.</p>
                            </div>
                        <?php else: ?>
                            <!-- Author Workflow Cards -->
                            <div class="p-6 rounded-2xl border border-white/5 hover:border-brand-primary/20 bg-white/1 transition-all group">
                                <div class="w-10 h-10 rounded-xl bg-brand-primary/10 text-brand-primary flex items-center justify-center mb-4">
                                    <i data-lucide="pen-tool" class="w-5 h-5"></i>
                                </div>
                                <h4 class="font-display font-bold text-white mb-2 group-hover:text-brand-primary transition-colors">Tulis Draft Baru</h4>
                                <p class="text-xs text-slate-400 leading-relaxed font-light">Mulai tuangkan ide kreatif Anda menjadi artikel draft yang menarik.</p>
                            </div>

                            <div class="p-6 rounded-2xl border border-white/5 hover:border-brand-primary/20 bg-white/1 transition-all group">
                                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center mb-4">
                                    <i data-lucide="book-open" class="w-5 h-5"></i>
                                </div>
                                <h4 class="font-display font-bold text-white mb-2 group-hover:text-brand-emerald transition-colors">Riwayat Tulisanku</h4>
                                <p class="text-xs text-slate-400 leading-relaxed font-light">Lihat daftar tulisan Anda yang telah diterbitkan maupun sedang direview.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
