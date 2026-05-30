<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($tagline ?? 'Sedang Dalam Perbaikan') ?> -
        <?= htmlspecialchars($companyName ?? 'NanasCMS') ?>
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen font-sans">
    <div class="text-center px-6 py-12 max-w-2xl bg-white shadow-xl rounded-2xl border border-gray-100">
        <div class="mb-6 flex justify-center">
            <!-- Icon Gear / Setting animatif -->
            <svg class="w-20 h-20 text-amber-500 animate-[spin_3s_linear_infinite]" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                </path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
        </div>

        <h1 class="text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">
            Situs Sedang Dalam Perbaikan
        </h1>

        <p class="text-lg mb-8 leading-relaxed">
            Kami sedang melakukan pemeliharaan pada <strong><?= htmlspecialchars($companyName ?? 'NanasCMS') ?></strong>
            untuk memberikan pengalaman yang lebih baik. Silakan kembali lagi nanti atau hubungi kami
            via email <a href="mailto:<?= htmlspecialchars($companyEmail) ?>"
                class="text-shadow-brand-secondary hover:text-shadow-brand-secondary-hover transition-colors font-bold"><?= htmlspecialchars($companyEmail) ?></a>,
            jika
            sangat mendesak.
        </p>


        <div class="mt-10 text-sm text-gray-500">
            &copy; <?= date('Y') ?> <?= htmlspecialchars($companyName ?? 'NanasCMS') ?>. All rights reserved.
        </div>
    </div>
</body>

</html>