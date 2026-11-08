<?php

namespace App\Helpers;

class MenuHelper
{
    /**
     * Menu utama WASKARA
     */
    public static function getMainNavItems(): array
    {
        return [
            [
                'icon' => 'dashboard',
                'name' => 'Dashboard',
                'path' => '/dashboard',
            ],
            [
                'icon' => 'video-camera',
                'name' => 'Live Detection',
                'path' => '/detection',
            ],
        ];
    }

    /**
     * Semua kelompok menu sidebar WASKARA
     */
    public static function getMenuGroups(): array
    {
        return [
            [
                'title' => 'MENU UTAMA',
                'items' => [
                    [
                        'icon' => 'dashboard',
                        'name' => 'Dashboard',
                        'path' => '/dashboard',
                    ],
                ],
            ],

            [
                'title' => 'LIVE DETECTION',
                'items' => [
                    [
                        'icon' => 'video-camera',
                        'name' => 'Webcam (Realtime)',
                        'path' => '/detection',
                    ],
                    [
                        'icon' => 'video',
                        'name' => 'Video',
                        'path' => '/video',
                    ],
                    [
                        'icon' => 'image',
                        'name' => 'Gambar',
                        'path' => '/image',
                    ],
                    [
                        'icon' => 'camera',
                        'name' => 'CCTV / ATCS',
                        'path' => '/cctv',
                    ],
                ],
            ],

            [
                'title' => 'ANALITIK',
                'items' => [
                    [
                        'icon' => 'bar-chart',
                        'name' => 'Statistik',
                        'path' => '/statistik',
                    ],
                    [
                        'icon' => 'target',
                        'name' => 'Evaluasi Model',
                        'path' => '/evaluasi',
                    ],
                ],
            ],

            [
                'title' => 'RIWAYAT',
                'items' => [
                    [
                        'icon' => 'alert-circle',
                        'name' => 'Riwayat Pelanggaran',
                        'path' => '/riwayat',
                    ],
                    [
                        'icon' => 'download',
                        'name' => 'Export Data',
                        'path' => '/export',
                    ],
                ],
            ],

            [
                'title' => 'SISTEM',
                'items' => [
                    [
                        'icon' => 'settings',
                        'name' => 'Pengaturan',
                        'path' => '/pengaturan',
                    ],
                    [
                        'icon' => 'info',
                        'name' => 'Tentang WASKARA',
                        'path' => '/tentang',
                    ],
                ],
            ],
        ];
    }
}