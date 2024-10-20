<?php

namespace App\Http\Controllers;

use App\Models\UserActivity;
use Illuminate\Http\Request;

class AdminActivityController extends Controller
{
    public function index()
    {
        // Pastikan menggunakan paginate() dan bukan all() atau get()
        $activities = UserActivity::with('user')->paginate(10); // 10 data per halaman

        return view('activities', compact('activities'));
    }
}
