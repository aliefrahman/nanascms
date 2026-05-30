<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Setting;
use Core\Config;
use Core\Auth;

class HomeController extends Controller
{
    /**
     * Display the main home page of the company profile.
     */
    public function index(): void
    {
        // Cek jika aplikasi dalam mode development dan user belum login
        if (Config::get('app.env') === 'development' && !Auth::check()) {
            $this->view('maintenance', [
                'companyName' => Setting::get('company_name'),
                'tagline' => 'Sedang Dalam Perbaikan'
            ]);
            return;
        }

        $data = [
            'companyName' => Setting::get('company_name'),
            'tagline' => 'Beranda',
            'services' => [
                [
                    'title' => 'Web Development',
                    'icon' => 'code-xml',
                    'description' => 'Membangun situs web dan aplikasi interaktif yang sangat responsif, cepat, dan dioptimalkan secara teknis.',
                    'color' => 'from-amber-400 to-amber-600'
                ],
                [
                    'title' => 'Brand Identity',
                    'icon' => 'sparkles',
                    'description' => 'Merancang identitas visual yang khas, mulai dari logo ikonik hingga panduan gaya visual yang berkarakter.',
                    'color' => 'from-emerald-400 to-emerald-600'
                ],
                [
                    'title' => 'AI Solutions & Systems',
                    'icon' => 'cpu',
                    'description' => 'Mengintegrasikan kecerdasan buatan untuk mengotomatisasi proses bisnis dan meningkatkan produktivitas tim.',
                    'color' => 'from-orange-400 to-amber-500'
                ],
                [
                    'title' => 'Premium UI/UX Design',
                    'icon' => 'layout-template',
                    'description' => 'Menghadirkan pengalaman pengguna yang menyenangkan, intuitif, dan secara visual mengagumkan.',
                    'color' => 'from-teal-400 to-emerald-500'
                ]
            ],
            'stats' => [
                ['value' => '10+', 'label' => 'Proyek Selesai'],
                ['value' => '2+', 'label' => 'Klien Global'],
                ['value' => '97%', 'label' => 'Tingkat Kepuasan'],
                ['value' => '3+', 'label' => 'Tahun Pengalaman']
            ],
            'projects' => [
                [
                    'title' => 'AgriTech Smart Dashboard',
                    'category' => 'Web System',
                    'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=800&q=80',
                    'link' => '#'
                ],
                [
                    'title' => 'Ethical Coffee Branding',
                    'category' => 'Brand Identity',
                    'image' => 'https://images.unsplash.com/photo-1511920170033-f8396924c348?auto=format&fit=crop&w=800&q=80',
                    'link' => '#'
                ],
                [
                    'title' => 'Cybersecurity Portal AI',
                    'category' => 'AI Integration',
                    'image' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=800&q=80',
                    'link' => '#'
                ]
            ],
            'testimonials' => [
                [
                    'quote' => 'Nanas Home Studio melampaui seluruh ekspektasi kami. Desain barunya sangat modern dan meningkatkan konversi penjualan kami hingga 45%!',
                    'author' => 'Ahmad R., CEO Terraspace',
                    'avatar' => 'AR'
                ],
                [
                    'quote' => 'Kolaborasi terbaik yang pernah kami lakukan. Tim mereka tanggap, kreatif, dan memiliki standar estetika yang luar biasa tinggi.',
                    'author' => 'Siti K., Head of Marketing KopiNusa',
                    'avatar' => 'SK'
                ]
            ]
        ];

        $this->view('home', $data);
    }
}
