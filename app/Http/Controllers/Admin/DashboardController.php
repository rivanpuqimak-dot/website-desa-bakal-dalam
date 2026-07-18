<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Official;
use App\Models\Gallery;
use App\Models\Potential;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahBerita = News::count();
        $jumlahAparat = Official::count();
        $jumlahGaleri = Gallery::count();
        $jumlahPotensi = Potential::count();

        $beritaTerbaru = News::latest()->take(5)->get();

        return view('admin.dashboard.index', compact(
            'jumlahBerita',
            'jumlahAparat',
            'jumlahGaleri',
            'jumlahPotensi',
            'beritaTerbaru'
        ));
    }
}