<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

use App\Models\Event;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        $stats = [];
        
        // User stats (for Admin/Operations Manager)
        if (auth()->user()->hasRole('Admin', 'Operations Manager')) {
            $stats['total_users'] = User::count();
            $stats['admin_users'] = User::whereHas('roles', function($q) {
                $q->where('name', 'Admin');
            })->count();
            $stats['recent_users'] = User::with('roles')
                ->latest()
                ->take(5)
                ->get();
        }
        
        
        
        return view('admin.dashboard', compact('stats'));
    }
}