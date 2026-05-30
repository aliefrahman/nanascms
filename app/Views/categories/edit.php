<?php include __DIR__ . '/../layout/header.php'; ?>

<!-- Categories Manager Container -->
<div class="max-w-3xl mx-auto px-6 mt-10 relative z-10 pb-12">
    <!-- Ambient background blobs -->
    <div class="blur-blob w-100 h-100 bg-brand-primary/5 -top-10 -left-10 animate-pulse-slow"></div>

    <!-- Page Title / Breadcrumb -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="font-display font-extrabold text-3xl text-white">Edit Kategori</h1>
            <p class="text-xs text-slate-500 mt-1 font-sans">Perbarui detail kategori Anda.</p>
        </div>
        
        <a href="<?= route('/categories') ?>" class="inline-flex items-center text-xs font-semibold text-slate-400 hover:text-brand-primary transition-colors group">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform"></i>
            <span>Kembali ke Kategori</span>
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
        <form action="<?= route('/categories/update?id=' . $category['id']) ?>" method="POST" class="space-y-6">
            
            <!-- Category Name -->
            <div class="space-y-2">
                <label for="name-input" class="text-xs font-semibold text-slate-300">Nama Kategori</label>
                <input type="text" 
                       name="name" 
                       id="name-input" 
                       value="<?= htmlspecialchars($category['name']) ?>" 
                       required 
                       autocomplete="off"
                       placeholder="Masukkan nama kategori" 
                       class="w-full bg-white/5 border border-white/10 focus:border-brand-primary/40 rounded-2xl py-3.5 px-4 text-sm text-white placeholder-slate-500 outline-none transition-all duration-300">
            </div>

            <!-- Category Slug -->
            <div class="space-y-2">
                <label for="slug-input" class="text-xs font-semibold text-slate-300">Slug Kategori (URL Path)</label>
                <input type="text" 
                       name="slug" 
                       id="slug-input" 
                       value="<?= htmlspecialchars($category['slug']) ?>" 
                       required 
                       autocomplete="off"
                       placeholder="slug-kategori-unik" 
                       class="w-full bg-white/5 border border-white/10 focus:border-brand-primary/40 rounded-2xl py-3.5 px-4 text-sm placeholder-slate-500 outline-none transition-all duration-300 font-mono text-brand-primary">
                
                <div class="flex items-center space-x-1.5 text-[10px] text-slate-500 mt-1 select-none font-sans">
                    <i data-lucide="link" class="w-3.5 h-3.5"></i>
                    <span>Preview Link: </span>
                    <span class="font-mono text-brand-primary/80 bg-brand-primary/5 px-1.5 py-0.5 rounded border border-brand-primary/10">
                        /category/<span id="slug-preview"><?= htmlspecialchars($category['slug']) ?></span>
                    </span>
                </div>
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label for="desc-input" class="text-xs font-semibold text-slate-300">Deskripsi (Opsional)</label>
                <textarea name="description" 
                          id="desc-input" 
                          rows="4" 
                          placeholder="Tulis penjelasan singkat mengenai kategori ini..." 
                          class="w-full bg-white/5 border border-white/10 focus:border-brand-primary/40 rounded-2xl py-3.5 px-4 text-sm text-white placeholder-slate-500 outline-none transition-all duration-300 resize-none"><?= htmlspecialchars($category['description'] ?? '') ?></textarea>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 flex items-center justify-end space-x-4 border-t border-white/5">
                <a href="<?= route('/categories') ?>" class="px-6 py-3 rounded-full text-xs font-bold text-slate-400 border border-white/5 hover:bg-white/5 hover:text-white transition-all">
                    Batal
                </a>
                
                <button type="submit" class="px-8 py-3.5 rounded-full font-bold text-dark-bg bg-brand-primary hover:bg-white hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 shadow-lg shadow-brand-primary/20 flex items-center space-x-2 text-xs">
                    <span>Perbarui Kategori</span>
                    <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name-input');
        const slugInput = document.getElementById('slug-input');
        const slugPreview = document.getElementById('slug-preview');

        // Helper to format slug
        function formatSlug(text) {
            return text.toLowerCase()
                       .replace(/[^a-z0-9\s-]/g, '')
                       .replace(/[\s-]+/g, '-')
                       .replace(/^-+|-+$/g, '');
        }

        // Live slug generation only if user edits the name
        nameInput.addEventListener('input', function() {
            let name = this.value;
            let slug = formatSlug(name);
            slugInput.value = slug;
            slugPreview.textContent = slug || 'slug-kategori';
        });

        // Live slug preview updates when user manual overrides the slug field
        slugInput.addEventListener('input', function() {
            let slug = formatSlug(this.value);
            this.value = slug; // enforce slug format
            slugPreview.textContent = slug || 'slug-kategori';
        });
    });
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
