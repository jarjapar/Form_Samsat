<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // pakai view yang sudah kamu punya: resources/views/admin/dashboard.blade.php
        return view('admin.dashboard');
    }
}
