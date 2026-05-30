<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="max-w-4xl mx-auto px-6 py-20 text-center relative z-10 font-sans">
    <!-- Ambient background blobs -->
    <div class="blur-blob w-80 h-80 bg-brand-primary/5 mx-auto -top-10 left-0 right-0 animate-pulse-slow"></div>
    
    <div class="space-y-6">
        <h1 class="font-display font-extrabold text-9xl text-transparent bg-clip-text bg-linear-to-r from-brand-secondary to-brand-primary animate-pulse">404</h1>
        <h2 class="font-display font-extrabold text-2xl text-white">Halaman Tidak Ditemukan</h2>
        <p class="text-slate-400 text-sm max-w-md mx-auto leading-relaxed">Maaf, halaman yang Anda cari tidak tersedia atau statusnya masih dalam draf.</p>
        
        <div class="pt-6">
            <a href="<?= route('/') ?>" class="inline-flex items-center justify-center px-6 py-3.5 rounded-full text-xs font-bold text-dark-bg bg-brand-primary hover:bg-white hover:scale-105 active:scale-95 transition-all shadow-lg shadow-brand-primary/20">
                <i data-lucide="home" class="w-4 h-4 mr-2"></i>
                <span>Kembali ke Beranda</span>
            </a>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
