<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $kategori = KategoriLayanan::count(); //menghitung jumlah data kategori
        return view('pages.dashboard', compact('kategori'));
    }
}
