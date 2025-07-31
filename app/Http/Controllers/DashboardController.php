<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        // Por ahora, el total de acciones es 0. Lo implementaremos más adelante.
        $totalActions = 0;

        return view('dashboard', compact('totalUsers', 'totalActions'));
    }

    public function listUsers()
{
    $users = User::all();
    return view('admin.users.index', compact('users'));
}
}
