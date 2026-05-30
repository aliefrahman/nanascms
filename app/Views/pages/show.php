<?php include __DIR__ . '/../layout/header.php'; ?>

<!-- Public Page Container -->
<div class="max-w-4xl mx-auto px-6 py-12 relative z-10 font-sans">
    <!-- Ambient background blobs -->
    <div class="blur-blob w-100 h-100 bg-brand-primary/5 -top-10 -left-10 animate-pulse-slow"></div>
    <div class="blur-blob w-100 h-100 bg-brand-secondary/5 bottom-10 right-10 animate-float-slow"></div>

    <article class="glass-card p-8 md:p-12 rounded-3xl border border-white/5 space-y-8">
        <!-- Page Title & Header info -->
        <header class="space-y-4 border-b border-white/5 pb-6">
            <h1 class="font-display font-extrabold text-4xl md:text-5xl text-white tracking-tight leading-tight">
                <?= htmlspecialchars($page['title']) ?>
            </h1>
            <div class="flex items-center text-xs text-slate-500 font-mono space-x-2">
                <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                <span>Dipublikasikan: <?= date('d M Y', strtotime($page['created_at'])) ?></span>
            </div>
        </header>

        <!-- Page Content -->
        <div class="prose prose-invert max-w-none text-slate-300 text-base leading-relaxed space-y-6 font-sans">
            <?= nl2br(htmlspecialchars($page['content'] ?? '')) ?>
        </div>
    </article>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>