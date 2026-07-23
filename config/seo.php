<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SEO Website Desa
    |--------------------------------------------------------------------------
    |
    | SEO_CANONICAL_URL harus berisi domain utama tanpa garis miring
    | di bagian akhir. GOOGLE_SITE_VERIFICATION diisi dengan token
    | dari Google Search Console, bukan seluruh tag HTML.
    |
    */

    'canonical_url' => rtrim(
        env(
            'SEO_CANONICAL_URL',
            env(
                'APP_URL',
                'https://desabakaldalam.web.id'
            )
        ),
        '/'
    ),

    'google_site_verification' => trim(
        (string) env(
            'GOOGLE_SITE_VERIFICATION',
            ''
        )
    ),

    'site_name' =>
        'Website Resmi Desa Bakal Dalam',

    'default_title' =>
        'Website Resmi Desa Bakal Dalam | Talo Kecil, Seluma',

    'default_description' =>
        'Website resmi Pemerintah Desa Bakal Dalam, Kecamatan Talo Kecil, Kabupaten Seluma, Provinsi Bengkulu. Informasi profil desa, pemerintahan, berita, galeri, potensi, layanan, pengumuman, agenda, dan kontak desa.',

];
