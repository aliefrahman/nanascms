<?php include __DIR__ . '/../layout/header.php'; 

function formatBytes($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow];
}
?>

<!-- Media Manager Container -->
<div class="max-w-7xl mx-auto px-6 mt-10 relative z-10 pb-12">
    <!-- Ambient background blobs -->
    <div class="blur-blob w-100 h-100 bg-brand-primary/5 -top-10 -left-10 animate-pulse-slow"></div>
    <div class="blur-blob w-100 h-100 bg-brand-emerald/5 bottom-10 right-10 animate-float-slow"></div>

    <!-- Page Title / Breadcrumb -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="font-display font-extrabold text-3xl text-white">Galeri Media Sentral</h1>
            <p class="text-xs text-slate-500 mt-1">Unggah, salin tautan, dan kelola file gambar secara sentral untuk digunakan kembali.</p>
        </div>
        
        <a href="<?= route('/dashboard') ?>" class="inline-flex items-center text-xs font-semibold text-slate-400 hover:text-brand-primary transition-colors group">
            <span>Kembali ke Dashboard</span>
            <i data-lucide="arrow-right" class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform"></i>
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

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left Column: Upload Form -->
        <div class="lg:col-span-4 glass-card p-8 rounded-3xl border border-white/5 space-y-6">
            <h3 class="font-display font-bold text-lg text-white border-b border-white/5 pb-4">Unggah File Baru</h3>
            
            <form action="<?= route('/media/upload') ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                <!-- Dropzone Area -->
                <div class="border-2 border-dashed border-white/10 hover:border-brand-primary/40 rounded-2xl p-8 flex flex-col items-center justify-center text-center cursor-pointer transition-colors relative group" id="dropzone-area">
                    <input type="file" name="file" id="file-input" required class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*">
                    <div class="w-12 h-12 rounded-xl bg-brand-primary/10 text-brand-primary flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i data-lucide="upload-cloud" class="w-6 h-6"></i>
                    </div>
                    <p class="text-sm font-semibold text-white">Seret file di sini atau klik</p>
                    <p class="text-xs text-slate-500 mt-2">Mendukung gambar JPG, PNG, GIF, WEBP, SVG (Maks. 5 MB)</p>
                </div>

                <!-- Preview Selected File -->
                <div id="file-preview-box" class="p-4 rounded-2xl bg-white/5 border border-white/5 flex items-center space-x-3" style="display:none">
                    <div class="w-10 h-10 rounded-lg bg-dark-bg/85 overflow-hidden flex items-center justify-center border border-white/10">
                        <img id="file-preview-img" src="" alt="" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p id="file-preview-name" class="text-xs font-bold text-white truncate"></p>
                        <p id="file-preview-size" class="text-[10px] text-slate-500"></p>
                    </div>
                    <button type="button" id="btn-remove-file" class="p-1 text-slate-500 hover:text-red-400">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </div>

                <button type="submit" class="w-full py-4 rounded-full font-bold text-dark-bg bg-brand-primary hover:bg-white hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 shadow-lg shadow-brand-primary/20 flex items-center justify-center space-x-2 text-sm">
                    <span>Mulai Mengunggah</span>
                    <i data-lucide="upload" class="w-4 h-4"></i>
                </button>
            </form>
        </div>

        <!-- Right Column: Media Grid Gallery -->
        <div class="lg:col-span-8 glass-card p-8 rounded-3xl border border-white/5 space-y-6">
            <h3 class="font-display font-bold text-lg text-white border-b border-white/5 pb-4">Galeri File</h3>
            
            <?php if (empty($mediaItems)): ?>
                <div class="py-20 flex flex-col items-center justify-center text-center">
                    <div class="w-16 h-16 rounded-2xl bg-white/5 flex items-center justify-center text-slate-600 mb-4">
                        <i data-lucide="image-off" class="w-8 h-8"></i>
                    </div>
                    <h4 class="font-display font-bold text-white">Galeri Media Kosong</h4>
                    <p class="text-xs text-slate-500 mt-1">Unggah gambar di panel kiri untuk mulai mengisi galeri media.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-6">
                    <?php foreach ($mediaItems as $item): 
                        $resolvedUrl = route($item['file_path']);
                    ?>
                        <div class="glass-card rounded-2xl border border-white/5 hover:border-brand-primary/20 overflow-hidden group flex flex-col justify-between transition-all duration-300 relative">
                            <!-- Image container (Click to View) -->
                            <div class="relative overflow-hidden aspect-4/3 bg-dark-bg/60 border-b border-white/5 flex items-center justify-center cursor-pointer group/img"
                                 onclick="openLightbox('<?= htmlspecialchars($resolvedUrl) ?>', '<?= route('/media/delete?id=' . $item['id']) ?>', '<?= htmlspecialchars(addslashes($item['original_name'])) ?>', '<?= formatBytes($item['file_size']) ?>', '<?= date('d M Y', strtotime($item['created_at'])) ?>')">
                                <img src="<?= htmlspecialchars($resolvedUrl) ?>" alt="<?= htmlspecialchars($item['original_name']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                
                                <!-- Hover Zoom Overlay -->
                                <div class="absolute inset-0 bg-dark-bg/40 opacity-0 group-hover/img:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                    <div class="w-10 h-10 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white flex items-center justify-center transform scale-90 group-hover/img:scale-100 transition-transform duration-300">
                                        <i data-lucide="zoom-in" class="w-5 h-5"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Meta Details & Actions -->
                            <div class="p-4 space-y-3">
                                <div>
                                    <p class="text-xs font-bold text-white truncate" title="<?= htmlspecialchars($item['original_name']) ?>"><?= htmlspecialchars($item['original_name']) ?></p>
                                    <div class="flex justify-between text-[10px] text-slate-500 mt-1">
                                        <span><?= formatBytes($item['file_size']) ?></span>
                                        <span><?= date('d M Y', strtotime($item['created_at'])) ?></span>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-3 gap-2 pt-1 border-t border-white/5">
                                    <!-- Lihat -->
                                    <button type="button" 
                                            onclick="openLightbox('<?= htmlspecialchars($resolvedUrl) ?>', '<?= route('/media/delete?id=' . $item['id']) ?>', '<?= htmlspecialchars(addslashes($item['original_name'])) ?>', '<?= formatBytes($item['file_size']) ?>', '<?= date('d M Y', strtotime($item['created_at'])) ?>')" 
                                            class="py-2 px-1 rounded-xl bg-white/5 hover:bg-white/10 border border-white/5 hover:border-brand-primary/30 text-[10px] font-semibold text-slate-300 hover:text-brand-primary flex flex-col items-center justify-center gap-1 transition-colors select-none" 
                                            title="Lihat Media">
                                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                        <span>Lihat</span>
                                    </button>

                                    <!-- Salin Link -->
                                    <button type="button" 
                                            onclick="copyToClipboard('<?= htmlspecialchars($resolvedUrl) ?>', this)" 
                                            class="py-2 px-1 rounded-xl bg-white/5 hover:bg-white/10 border border-white/5 hover:border-brand-primary/30 text-[10px] font-semibold text-slate-300 hover:text-brand-primary flex flex-col items-center justify-center gap-1 transition-colors select-none" 
                                            title="Salin URL Gambar">
                                        <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                                        <span>Salin URL</span>
                                    </button>

                                    <!-- Hapus -->
                                    <a href="<?= route('/media/delete?id=' . $item['id']) ?>" 
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus gambar ini?');" 
                                       class="py-2 px-1 rounded-xl bg-white/5 hover:bg-red-500/10 border border-white/5 hover:border-red-500/20 text-[10px] font-semibold text-slate-300 hover:text-red-400 flex flex-col items-center justify-center gap-1 transition-all select-none" 
                                       title="Hapus Media">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        <span>Hapus</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Lightbox Modal -->
<div id="lightbox-modal" class="fixed inset-0 z-50 invisible opacity-0 transition-all duration-300 flex items-center justify-center p-4">
    <!-- Backdrop with blur -->
    <div class="absolute inset-0 bg-dark-bg/90 backdrop-blur-md cursor-pointer" onclick="closeLightbox()"></div>
    
    <!-- Modal Content -->
    <div class="glass-card max-w-4xl w-full rounded-3xl border border-white/10 overflow-hidden relative z-10 flex flex-col md:flex-row transform scale-95 duration-300" id="lightbox-content">
        <!-- Close Button (Top Right) -->
        <button type="button" onclick="closeLightbox()" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/10 border border-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all z-20">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>

        <!-- Left: Image Preview Container -->
        <div class="md:w-2/3 aspect-video md:aspect-auto md:h-[60vh] bg-black/40 flex items-center justify-center p-4 border-b md:border-b-0 md:border-r border-white/5">
            <img id="lightbox-img" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">
        </div>

        <!-- Right: Image Details -->
        <div class="md:w-1/3 p-6 flex flex-col justify-between bg-dark-bg/40 backdrop-blur-md">
            <div class="space-y-6">
                <div>
                    <span class="text-[10px] font-bold tracking-wider text-brand-primary uppercase">Detail Gambar</span>
                    <h4 id="lightbox-name" class="font-display font-bold text-lg text-white mt-1 break-all"></h4>
                </div>

                <div class="space-y-3 border-t border-white/5 pt-4">
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-400">Ukuran File</span>
                        <span id="lightbox-size" class="text-white font-semibold"></span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-400">Tanggal Unggah</span>
                        <span id="lightbox-date" class="text-white font-semibold"></span>
                    </div>
                </div>
            </div>

            <div class="mt-8 space-y-3">
                <button type="button" id="lightbox-copy-btn" class="w-full py-3.5 rounded-full font-bold text-dark-bg bg-brand-primary hover:bg-white transition-all flex items-center justify-center space-x-2 text-xs shadow-lg shadow-brand-primary/20">
                    <i data-lucide="copy" class="w-4 h-4"></i>
                    <span>Salin URL Gambar</span>
                </button>
                
                <a id="lightbox-delete-link" href="" onclick="return confirm('Apakah Anda yakin ingin menghapus gambar ini?');" class="w-full py-3.5 rounded-full font-bold border border-white/10 hover:border-red-500/30 text-slate-300 hover:text-red-400 transition-all flex items-center justify-center space-x-2 text-xs hover:bg-red-500/10">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                    <span>Hapus Gambar</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('file-input');
        const dropzone = document.getElementById('dropzone-area');
        const previewBox = document.getElementById('file-preview-box');
        const previewImg = document.getElementById('file-preview-img');
        const previewName = document.getElementById('file-preview-name');
        const previewSize = document.getElementById('file-preview-size');
        const btnRemove = document.getElementById('btn-remove-file');

        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                previewName.textContent = file.name;
                previewSize.textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
                
                // Show preview if image
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        previewImg.src = event.target.result;
                        previewBox.style.display = 'flex';
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewBox.style.display = 'flex';
                }
            }
        });

        btnRemove.addEventListener('click', function() {
            fileInput.value = '';
            previewBox.style.display = 'none';
            previewImg.src = '';
        });

        // Dropzone drag/drop listeners
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, function(e) {
                e.preventDefault();
                dropzone.classList.add('border-brand-primary/60', 'bg-white/[2%]');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, function(e) {
                e.preventDefault();
                dropzone.classList.remove('border-brand-primary/60', 'bg-white/[2%]');
            }, false);
        });
    });

    function openLightbox(url, deleteUrl, name, size, date) {
        const modal = document.getElementById('lightbox-modal');
        const content = document.getElementById('lightbox-content');
        const img = document.getElementById('lightbox-img');
        const nameEl = document.getElementById('lightbox-name');
        const sizeEl = document.getElementById('lightbox-size');
        const dateEl = document.getElementById('lightbox-date');
        const copyBtn = document.getElementById('lightbox-copy-btn');
        const deleteLink = document.getElementById('lightbox-delete-link');

        // Set content
        img.src = url;
        img.alt = name;
        nameEl.textContent = name;
        sizeEl.textContent = size;
        dateEl.textContent = date;

        // Set up Copy action inside lightbox
        copyBtn.onclick = function() {
            copyToClipboard(url, copyBtn);
        };

        // Set up Delete action inside lightbox
        deleteLink.href = deleteUrl;

        // Show modal with animations
        modal.classList.remove('invisible', 'opacity-0');
        modal.classList.add('visible', 'opacity-100');
        content.classList.remove('scale-95');
        content.classList.add('scale-100');
        
        // Disable body scroll
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        const modal = document.getElementById('lightbox-modal');
        const content = document.getElementById('lightbox-content');
        
        modal.classList.remove('visible', 'opacity-100');
        modal.classList.add('invisible', 'opacity-0');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');
        
        // Re-enable body scroll
        document.body.style.overflow = '';
    }

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });

    function copyToClipboard(text, element) {
        // Resolve absolute URL
        const absoluteUrl = window.location.origin + text;
        navigator.clipboard.writeText(absoluteUrl).then(function() {
            const originalHtml = element.innerHTML;
            element.innerHTML = '<i data-lucide="check" class="w-3.5 h-3.5 text-emerald-400"></i><span class="text-emerald-400">Tersalin!</span>';
            lucide.createIcons();
            
            setTimeout(function() {
                element.innerHTML = originalHtml;
                lucide.createIcons();
            }, 2000);
        }).catch(function(err) {
            console.error('Gagal menyalin: ', err);
        });
    }
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
