<?php include __DIR__ . '/layout/header.php';

use App\Models\Setting; ?>

<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center pt-16 pb-16 overflow-hidden dot-bg">
    <!-- Glowing background blobs -->
    <div class="blur-blob w-180 h-180 bg-brand-primary/10 -top-40 -left-40 animate-pulse-slow"></div>
    <div class="blur-blob w-140 h-140 bg-brand-emerald/10 -bottom-20 -right-20 animate-float-slow"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10 w-full grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <!-- Text Hero -->
        <div class="lg:col-span-7 space-y-8 text-center lg:text-left">
            <div
                class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full border border-brand-primary/20  text-xs font-semibold uppercase tracking-widest animate-fade-in">
                <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                <span class="text-brand-primary in-[.light-theme]:text-black">Agensi Kreatif Digital Terdepan</span>
            </div>

            <h1
                class="font-display font-extrabold text-5xl sm:text-6xl md:text-7xl leading-[1.1] tracking-tight text-gradient-white">
                <?= Setting::get('tagline') ?>
            </h1>

            <p class="text-lg md:text-xl text-slate-400 max-w-xl mx-auto lg:mx-0 leading-relaxed font-light">
                <?= $description ?>
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-4">
                <a href="#contact"
                    class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 rounded-full font-bold text-dark-bg bg-brand-primary hover:bg-white transition-all duration-300 shadow-lg shadow-brand-primary/20 hover:scale-105 active:scale-95 group">
                    <span>Mulai Diskusi</span>
                    <i data-lucide="arrow-right"
                        class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>
                <a href="#portfolio"
                    class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 rounded-full font-bold border border-white/10 hover:border-white/20 bg-white/5 hover:bg-white/10 transition-all duration-300 backdrop-blur-sm">
                    <span>Lihat Portofolio</span>
                </a>
            </div>
        </div>

        <!-- Interactive Hero Visual -->
        <div class="lg:col-span-5 relative flex justify-center items-center">
            <!-- Glowing Ring Visual -->
            <div
                class="relative w-80 h-80 md:w-96 md:h-96 rounded-full bg-linear-to-tr from-brand-secondary/30 via-brand-primary/10 to-brand-emerald/20 p-px animate-float-slow">
                <div
                    class="w-full h-full rounded-full bg-dark-bg/90 flex items-center justify-center relative overflow-hidden">
                    <!-- Rotating Grid texture -->
                    <div class="absolute inset-0 grid-bg animate-spin-slow opacity-30"></div>

                    <!-- Floating Interactive Pineapple Icon -->
                    <div
                        class="relative z-10 p-8 rounded-3xl glass-card flex flex-col items-center justify-center border border-white/10 animate-float-mid shadow-2xl">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-24 h-24 stroke-[1.5] text-brand-primary glow-amber" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor">
                            <path d="M12 2v3M9.5 3.5l1.5 2.5M14.5 3.5l-1.5 2.5" />
                            <rect x="7" y="9" width="10" height="12" rx="4" fill="currentColor" fill-opacity="0.1" />
                            <path d="M7 13l10 5M7 18l10-5M10 9l4 12" />
                        </svg>
                        <span class="mt-4 font-display font-bold text-xs uppercase tracking-widest text-slate-400">Est.
                            2023</span>
                    </div>

                    <!-- Glowing core -->
                    <div class="absolute w-24 h-24 rounded-full bg-brand-primary/20 blur-xl"></div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- About Section -->
<section id="about" class="py-24 relative overflow-hidden bg-dark-bg">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
        <!-- Statistics Block -->
        <div class="lg:col-span-5 grid grid-cols-2 gap-6 order-2 lg:order-1 relative">
            <!-- Subtle glow in stats -->
            <div class="blur-blob w-60 h-60 bg-brand-emerald/5 -top-10 -left-10"></div>

            <?php foreach ($stats as $stat): ?>
                <div
                    class="glass-card p-8 rounded-2xl border border-white/5 hover:border-brand-primary/20 transition-all duration-300">
                    <h3 class="font-display font-extrabold text-4xl text-brand-primary mb-2"><?= $stat['value'] ?></h3>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider"><?= $stat['label'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- About Content -->
        <div class="lg:col-span-7 order-1 lg:order-2 space-y-6">
            <h2
                class="font-display font-extrabold text-sm uppercase tracking-widest text-brand-primary in-[.light-theme]:text-black">
                Siapa Kami
            </h2>
            <h3 class="font-display font-extrabold text-3xl sm:text-4xl md:text-5xl leading-tight text-white">
                Memadukan Estetika Seni & Ketangguhan Teknologi.
            </h3>
            <p class="text-slate-400 leading-relaxed font-light">
                Kami percaya bahwa kehadiran digital tidak hanya harus bekerja secara fungsional, tetapi juga harus
                menginspirasi audiens Anda secara visual. Di era digital yang bising, kami membantu brand Anda menonjol
                dan diingat.
            </p>
            <div class="pt-4 flex flex-col sm:flex-row gap-6">
                <div class="flex items-start space-x-4">
                    <div
                        class="w-10 h-10 rounded-xl bg-brand-primary/10 flex items-center justify-center text-brand-primary shrink-0">
                        <i data-lucide="eye" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="font-display font-bold text-base text-white mb-1">Visi Kami</h4>
                        <p class="text-sm text-slate-400">Menjadi pusat inovasi kreatif yang menginspirasi lahirnya
                            produk digital berkualitas global.</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div
                        class="w-10 h-10 rounded-xl bg-brand-emerald/10 flex items-center justify-center text-brand-emerald shrink-0">
                        <i data-lucide="zap" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="font-display font-bold text-base text-white mb-1">Misi Kami</h4>
                        <p class="text-sm text-slate-400">Menyediakan solusi digital canggih dan desain kelas satu yang
                            mendukung keunggulan kompetitif klien.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="py-24 relative overflow-hidden bg-dark-surface/30 grid-bg">
    <!-- Glow in background -->
    <div class="blur-blob w-160 h-160 bg-brand-primary/5 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
    </div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="text-center max-w-2xl mx-auto mb-20 space-y-4">
            <h2
                class="font-display font-extrabold text-sm uppercase tracking-widest text-brand-primary in-[.light-theme]:text-black">
                Layanan Utama
            </h2>
            <h3 class="font-display font-extrabold text-3xl sm:text-4xl md:text-5xl text-white">Layanan Khusus untuk
                Mendukung Bisnis Anda</h3>
            <p class="text-slate-400 font-light">Kami menawarkan portofolio layanan lengkap yang dirancang untuk
                memperkuat fondasi digital bisnis Anda.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php foreach ($services as $service): ?>
                <div class="glass-card glass-card-hover p-8 rounded-3xl relative overflow-hidden group">
                    <!-- Subtle corner gradient glow -->
                    <div
                        class="absolute -top-12 -right-12 w-24 h-24 bg-linear-to-br <?= $service['color'] ?> opacity-10 blur-xl group-hover:opacity-30 transition-opacity">
                    </div>

                    <div
                        class="w-12 h-12 bg-linear-to-tr <?= $service['color'] ?> rounded-2xl flex items-center justify-center text-dark-bg mb-8 shadow-md">
                        <i data-lucide="<?= $service['icon'] ?>" class="w-6 h-6 stroke-2"></i>
                    </div>

                    <h4
                        class="font-display font-bold text-xl text-white mb-4 group-hover:text-brand-primary transition-colors">
                        <?= $service['title'] ?>
                    </h4>
                    <p class="text-sm text-slate-400 leading-relaxed font-light"><?= $service['description'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Portfolio Section -->
<section id="portfolio" class="py-24 relative overflow-hidden bg-dark-bg">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-20">
            <div class="space-y-4">
                <h2
                    class="font-display font-extrabold text-sm uppercase tracking-widest text-brand-primary in-[.light-theme]:text-black">
                    Karya Kami
                </h2>
                <h3 class="font-display font-extrabold text-3xl sm:text-4xl md:text-5xl text-white">Proyek Unggulan
                    Pilihan</h3>
            </div>
            <a href="#"
                class="inline-flex items-center text-sm font-semibold text-brand-primary in-[.light-theme]:bg-brand-primary in-[.light-theme]:text-black in-[.light-theme]:px-4 in-[.light-theme]:py-2 in-[.light-theme]:rounded-full hover:text-white transition-colors group">
                <span>Lihat Semua Proyek</span>
                <i data-lucide="arrow-up-right"
                    class="w-4 h-4 ml-1 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach ($projects as $project): ?>
                <div
                    class="glass-card rounded-3xl overflow-hidden group border border-white/5 hover:border-brand-primary/20 transition-all duration-300">
                    <div class="relative overflow-hidden aspect-4/3">
                        <img src="<?= $project['image'] ?>" alt="<?= $project['title'] ?>"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 filter grayscale group-hover:grayscale-0">
                        <div
                            class="absolute inset-0 bg-linear-to-t from-dark-bg via-transparent to-transparent opacity-60 group-hover:opacity-40 transition-opacity">
                        </div>
                    </div>
                    <div class="p-8">
                        <span
                            class="text-xs font-semibold uppercase text-brand-primary tracking-widest"><?= $project['category'] ?></span>
                        <h4
                            class="font-display font-bold text-xl text-white mt-2 group-hover:text-brand-primary transition-colors">
                            <?= $project['title'] ?>
                        </h4>
                        <a href="<?= $project['link'] ?>"
                            class="mt-6 inline-flex items-center text-xs font-bold text-slate-400 hover:text-white transition-colors group/link">
                            <span>Jelajahi Proyek</span>
                            <i data-lucide="chevron-right"
                                class="w-4 h-4 ml-1 group-hover/link:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Testimonial Section -->
<section id="testimonials" class="py-24 relative overflow-hidden bg-dark-surface/20 border-y border-white/5">
    <div class="blur-blob w-120 h-120 bg-brand-emerald/5 -bottom-20 -left-20"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="text-center max-w-2xl mx-auto mb-20 space-y-4">
            <h2 class="font-display font-extrabold text-sm text-brand-primary uppercase tracking-widest">Testimoni Klien
            </h2>
            <h3 class="font-display font-extrabold text-3xl sm:text-4xl md:text-5xl text-white">Apa Kata Mereka Tentang
                Kami</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <?php foreach ($testimonials as $testimonial): ?>
                <div class="glass-card p-8 rounded-3xl border border-white/5 relative flex flex-col justify-between">
                    <!-- Decorative quotes icon -->
                    <i data-lucide="quote" class="absolute top-6 right-6 w-8 h-8 text-brand-primary/10 stroke-[1.5]"></i>

                    <p class="text-slate-300 text-lg italic leading-relaxed font-light mb-8">
                        "<?= $testimonial['quote'] ?>"
                    </p>

                    <div class="flex items-center space-x-4">
                        <div
                            class="w-10 h-10 rounded-full bg-brand-primary/20 flex items-center justify-center text-brand-primary font-bold text-xs">
                            <?= $testimonial['avatar'] ?>
                        </div>
                        <div>
                            <h4 class="font-display font-bold text-sm text-white"><?= $testimonial['author'] ?></h4>
                            <p class="text-xs text-slate-500">Klien Terverifikasi</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Contact Form Section -->
<section id="contact" class="py-24 relative overflow-hidden bg-dark-bg">
    <!-- Background glow -->
    <div class="blur-blob w-180 h-180 bg-brand-primary/5 -top-40 -right-40 animate-pulse-slow"></div>

    <div class="max-w-4xl mx-auto px-6 relative z-10">
        <div class="glass-card p-12 md:p-16 rounded-[2.5rem] border border-white/5 relative overflow-hidden">
            <div
                class="absolute top-0 right-0 w-32 h-32 bg-linear-to-br from-brand-primary to-brand-emerald opacity-5 blur-2xl">
            </div>

            <div class="text-center max-w-xl mx-auto mb-12 space-y-4">
                <div class="inline-flex p-3 rounded-2xl bg-brand-primary/10 text-brand-primary mb-2">
                    <i data-lucide="mail" class="w-6 h-6"></i>
                </div>
                <h3 class="font-display font-extrabold text-3xl sm:text-4xl text-white">Hubungi Tim Kami</h3>
                <p class="text-slate-400 font-light">Diskusikan kebutuhan proyek Anda dan dapatkan proposal penawaran
                    khusus gratis dalam 24 jam.</p>
            </div>

            <form action="#" method="POST" class="space-y-6"
                onsubmit="event.preventDefault(); alert('Pesan Anda telah dikirim! Tim kami akan menghubungi Anda segera.'); this.reset();">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="name" class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama
                            Lengkap</label>
                        <input type="text" id="name" required
                            class="w-full px-5 py-4 rounded-2xl bg-dark-bg/60 border border-white/10 focus:border-brand-primary/50 text-white placeholder-slate-600 focus:outline-none transition-colors"
                            placeholder="Masukkan nama Anda">
                    </div>

                    <div class="space-y-2">
                        <label for="email" class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Alamat
                            Email</label>
                        <input type="email" id="email" required
                            class="w-full px-5 py-4 rounded-2xl bg-dark-bg/60 border border-white/10 focus:border-brand-primary/50 text-white placeholder-slate-600 focus:outline-none transition-colors"
                            placeholder="nama@perusahaan.com">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="service_type"
                        class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Layanan yang
                        Dibutuhkan</label>
                    <select id="service_type"
                        class="w-full px-5 py-4 rounded-2xl bg-dark-bg/60 border border-white/10 focus:border-brand-primary/50 text-white focus:outline-none transition-colors cursor-pointer">
                        <option class="bg-dark-surface" value="web">Web Development</option>
                        <option class="bg-dark-surface" value="branding">Brand Identity</option>
                        <option class="bg-dark-surface" value="ai">AI Integration</option>
                        <option class="bg-dark-surface" value="uiux">UI/UX Design</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label for="message" class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pesan
                        Proyek</label>
                    <textarea id="message" rows="5" required
                        class="w-full px-5 py-4 rounded-2xl bg-dark-bg/60 border border-white/10 focus:border-brand-primary/50 text-white placeholder-slate-600 focus:outline-none transition-colors resize-none"
                        placeholder="Ceritakan detail proyek Anda secara singkat..."></textarea>
                </div>

                <button type="submit"
                    class="w-full py-4 rounded-full font-bold text-dark-bg bg-brand-primary hover:bg-white hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 shadow-lg shadow-brand-primary/20 flex items-center justify-center space-x-2">
                    <span>Kirim Pesan Proyek</span>
                    <i data-lucide="send" class="w-4 h-4"></i>
                </button>
            </form>
        </div>
    </div>
</section>

<?php include __DIR__ . '/layout/footer.php'; ?>