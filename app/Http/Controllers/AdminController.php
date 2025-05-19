<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Bisa kirim data ke view jika perlu
        return view('admin.dashboard');
    }
}
