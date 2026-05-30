<?php include __DIR__ . '/../layout/header.php'; ?>

    <!-- Main Container -->
    <div class="max-w-xl mx-auto px-6 mt-10 relative z-10 pb-12">
        <!-- Back Link -->
        <a href="<?= route('/users') ?>" class="inline-flex items-center text-xs font-semibold text-slate-400 hover:text-brand-primary mb-8 transition-colors group">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform"></i>
            <span>Kembali ke Daftar Pengguna</span>
        </a>

        <!-- Glassmorphic Card -->
        <div class="glass-card p-10 md:p-12 rounded-4xl border border-white/5 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-linear-to-br from-brand-primary to-brand-emerald opacity-5 blur-2xl"></div>
            
            <div class="text-center mb-8">
                <h2 class="font-display font-extrabold text-2xl text-white">Edit Pengguna</h2>
                <p class="text-xs text-slate-400 mt-2">Sunting detail akun atau ubah hak akses pengguna</p>
            </div>

            <!-- Flash Session Alerts -->
            <?php if (isset($_SESSION['flash_error'])): ?>
                <div class="mb-6 p-4 rounded-xl border border-red-500/20 bg-red-500/10 text-red-400 text-xs flex items-start space-x-2">
                    <i data-lucide="alert-circle" class="w-4 h-4 shrink-0 mt-0.5"></i>
                    <span><?= $_SESSION['flash_error']; unset($_SESSION['flash_error']); ?></span>
                </div>
            <?php endif; ?>

            <!-- Edit User Form -->
            <form action="<?= route('/users/update') ?>" method="POST" class="space-y-6">
                <!-- Hidden User ID -->
                <input type="hidden" name="id" value="<?= $user['id'] ?>">

                <div class="space-y-2">
                    <label for="username" class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Username</label>
                    <div class="relative">
                        <i data-lucide="user" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"></i>
                        <input type="text" id="username" name="username" required value="<?= htmlspecialchars($user['username']) ?>" class="w-full pl-11 pr-5 py-4 rounded-xl bg-dark-bg/60 border border-white/10 focus:border-brand-primary/50 text-white placeholder-slate-600 focus:outline-none transition-colors text-sm" placeholder="Masukkan username">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="fullname" class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama Lengkap</label>
                    <div class="relative">
                        <i data-lucide="user" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"></i>
                        <input type="text" id="fullname" name="fullname" value="<?= htmlspecialchars($user['fullname'] ?? '') ?>" class="w-full pl-11 pr-5 py-4 rounded-xl bg-dark-bg/60 border border-white/10 focus:border-brand-primary/50 text-white placeholder-slate-600 focus:outline-none transition-colors text-sm" placeholder="Masukkan nama lengkap">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="email" class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Email</label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"></i>
                        <input type="email" id="email" name="email" required value="<?= htmlspecialchars($user['email']) ?>" class="w-full pl-11 pr-5 py-4 rounded-xl bg-dark-bg/60 border border-white/10 focus:border-brand-primary/50 text-white placeholder-slate-600 focus:outline-none transition-colors text-sm" placeholder="nama@perusahaan.com">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="avatar" class="text-xs font-semibold text-slate-400 uppercase tracking-wider">URL Avatar (Opsional)</label>
                    <div class="flex gap-2">
                        <div class="relative flex-1">
                            <i data-lucide="image" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"></i>
                            <input type="url" id="avatar" name="avatar" value="<?= htmlspecialchars($user['avatar'] ?? '') ?>" class="w-full pl-11 pr-5 py-4 rounded-xl bg-dark-bg/60 border border-white/10 focus:border-brand-primary/50 text-white placeholder-slate-600 focus:outline-none transition-colors text-sm" placeholder="https://images.unsplash.com/photo-...">
                        </div>
                        <button type="button" id="btn-media-picker" class="px-4 py-4 rounded-xl border border-white/10 hover:border-brand-primary/30 bg-white/5 hover:bg-white/10 text-brand-primary text-xs font-bold transition-all duration-300 flex items-center space-x-1 focus:outline-none active:scale-95" title="Pilih dari Media Sentral">
                            <i data-lucide="folder-open" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <label for="password" class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kata Sandi Baru</label>
                        <span class="text-[10px] text-slate-500 font-light">*Kosongkan jika tidak ingin mengubah</span>
                    </div>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"></i>
                        <input type="password" id="password" name="password" class="w-full pl-11 pr-5 py-4 rounded-xl bg-dark-bg/60 border border-white/10 focus:border-brand-primary/50 text-white placeholder-slate-600 focus:outline-none transition-colors text-sm" placeholder="Masukkan password baru">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="role_id" class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pilih Hak Akses (Role)</label>
                    <div class="relative">
                        <i data-lucide="shield" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"></i>
                        <select id="role_id" name="role_id" required class="w-full pl-11 pr-5 py-4 rounded-xl bg-dark-bg/60 border border-white/10 focus:border-brand-primary/50 text-white focus:outline-none transition-colors text-sm cursor-pointer appearance-none">
                            <?php foreach ($roles as $r): ?>
                                <option class="bg-dark-surface text-white" value="<?= $r['id'] ?>" <?= $r['id'] == $user['role_id'] ? 'selected' : '' ?>><?= htmlspecialchars($r['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500 pointer-events-none"></i>
                    </div>
                </div>

                <button type="submit" class="w-full py-4 rounded-full font-bold text-dark-bg bg-brand-primary hover:bg-white hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 shadow-lg shadow-brand-primary/20 flex items-center justify-center space-x-2 text-sm mt-8">
                    <span>Perbarui Pengguna</span>
                    <i data-lucide="user-check" class="w-4 h-4"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Media Picker Modal HTML -->
    <div id="media-picker-modal" class="fixed inset-0 z-100 items-center justify-center bg-dark-bg/85 backdrop-blur-md transition-opacity duration-300" style="display:none">
        <div class="glass-card max-w-xl w-full p-6 md:p-8 rounded-4xl border border-white/5 shadow-2xl relative flex flex-col max-h-[80vh] mx-4">
            <!-- Close Button -->
            <button id="media-picker-close" class="absolute top-4 right-4 p-2 text-slate-400 hover:text-white transition-colors">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>

            <h3 class="font-display font-extrabold text-xl text-white mb-1">Pilih Media</h3>
            <p class="text-xs text-slate-500 mb-6">Pilih gambar yang sudah diunggah sebelumnya atau unggah file baru langsung di sini.</p>

            <!-- Upload directly from modal -->
            <div id="modal-upload-container" class="border border-dashed border-white/10 hover:border-brand-primary/40 rounded-xl p-4 text-center cursor-pointer transition-colors relative mb-6">
                <input type="file" id="modal-file-input" class="absolute inset-0 opacity-0 cursor-pointer">
                <div class="flex items-center justify-center space-x-2 text-xs font-semibold text-brand-primary">
                    <i data-lucide="upload-cloud" class="w-4 h-4"></i>
                    <span>Unggah Gambar Baru</span>
                </div>
                <p id="modal-upload-status" class="text-[9px] text-slate-500 mt-1">Hingga 5 MB (JPG, PNG, GIF, WEBP, SVG)</p>
            </div>

            <!-- Media Grid -->
            <div id="modal-media-grid" class="grid grid-cols-3 sm:grid-cols-4 gap-4 overflow-y-auto pr-1 flex-1 min-h-[200px]">
                <!-- Populated via JS -->
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        document.addEventListener('DOMContentLoaded', function() {
            const avatarInput = document.getElementById('avatar');
            const pickerModal = document.getElementById('media-picker-modal');
            const pickerClose = document.getElementById('media-picker-close');
            const pickerTrigger = document.getElementById('btn-media-picker');
            const modalMediaGrid = document.getElementById('modal-media-grid');
            const modalFileInput = document.getElementById('modal-file-input');
            const modalUploadStatus = document.getElementById('modal-upload-status');

            if (pickerModal && pickerTrigger) {
                pickerTrigger.addEventListener('click', function() {
                    pickerModal.style.display = 'flex';
                    loadMediaList();
                });

                pickerClose.addEventListener('click', function() {
                    pickerModal.style.display = 'none';
                });

                pickerModal.addEventListener('click', function(e) {
                    if (e.target === pickerModal) {
                        pickerModal.style.display = 'none';
                    }
                });

                function loadMediaList() {
                    modalMediaGrid.innerHTML = `
                        <div class="col-span-full py-12 flex flex-col items-center justify-center text-center text-slate-500">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-brand-primary"></div>
                            <span class="text-xs mt-3">Memuat media...</span>
                        </div>
                    `;

                    fetch('<?= route('/api/media') ?>')
                        .then(res => res.json())
                        .then(data => {
                            if (data.success && data.media.length > 0) {
                                modalMediaGrid.innerHTML = '';
                                data.media.forEach(item => {
                                    const cell = document.createElement('div');
                                    cell.className = 'glass-card rounded-xl border border-white/5 overflow-hidden cursor-pointer hover:border-brand-primary/50 transition-colors aspect-square flex items-center justify-center relative group';
                                    cell.innerHTML = `
                                        <img src="${item.url}" alt="${item.filename}" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-dark-bg/60 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                                            <span class="text-[9px] font-bold text-white uppercase tracking-wider bg-brand-primary/20 border border-brand-primary/30 px-2 py-0.5 rounded">Pilih</span>
                                        </div>
                                    `;
                                    cell.addEventListener('click', function() {
                                        avatarInput.value = item.url;
                                        pickerModal.style.display = 'none';
                                    });
                                    modalMediaGrid.appendChild(cell);
                                });
                            } else {
                                modalMediaGrid.innerHTML = `
                                    <div class="col-span-full py-12 flex flex-col items-center justify-center text-center text-slate-500">
                                        <i data-lucide="image-off" class="w-8 h-8 mb-2"></i>
                                        <span class="text-xs">Galeri media kosong.</span>
                                    </div>
                                `;
                                lucide.createIcons();
                            }
                        })
                        .catch(err => {
                            modalMediaGrid.innerHTML = `
                                <div class="col-span-full py-12 flex flex-col items-center justify-center text-center text-red-400">
                                    <i data-lucide="alert-circle" class="w-8 h-8 mb-2"></i>
                                    <span class="text-xs">Gagal memuat media.</span>
                                </div>
                            `;
                            lucide.createIcons();
                        });
                }

                modalFileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (!file) return;

                    const formData = new FormData();
                    formData.append('file', file);

                    modalUploadStatus.innerHTML = '<span class="text-brand-primary">Mengunggah...</span>';

                    fetch('<?= route('/api/media/upload') ?>', {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            modalUploadStatus.innerHTML = '<span class="text-emerald-400">Berhasil!</span>';
                            setTimeout(() => {
                                modalUploadStatus.textContent = 'Hingga 5 MB (JPG, PNG, GIF, WEBP, SVG)';
                            }, 2000);
                            loadMediaList();
                        } else {
                            modalUploadStatus.innerHTML = `<span class="text-red-400">${data.error || 'Gagal.'}</span>`;
                            setTimeout(() => {
                                modalUploadStatus.textContent = 'Hingga 5 MB (JPG, PNG, GIF, WEBP, SVG)';
                            }, 4000);
                        }
                    })
                    .catch(err => {
                        modalUploadStatus.innerHTML = '<span class="text-red-400">Error jaringan.</span>';
                        setTimeout(() => {
                            modalUploadStatus.textContent = 'Hingga 5 MB (JPG, PNG, GIF, WEBP, SVG)';
                        }, 4000);
                    });
                });
            }
        });
    </script>
<?php include __DIR__ . '/../layout/footer.php'; ?>
