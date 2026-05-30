<?php

return [
    // Nama Aplikasi
    'name' => \Core\Config::env('APP_NAME', 'NanasCMS'),

    // Base URL aplikasi (Sesuaikan dengan domain / folder project Anda)
    'base_url' => \Core\Config::env('APP_BASE_URL', 'http://localhost/nanascms/public'),

    // Pengaturan zona waktu (Timezone)
    'timezone' => \Core\Config::env('APP_TIMEZONE', 'Asia/Makassar'),

    // Pengaturan environment (development / production)
    'env' => \Core\Config::env('APP_ENV', 'development'),
];