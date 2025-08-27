<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller{
    
    public function index()
    {
        $userCount = User::count();
        $activityCount = Activity::count();
        $activities = Activity::latest()->get();

        return view('dashboard', compact('userCount', 'activityCount', 'activities'));
    }

    public function showAuditLog(){

        $activities = Activity::latest()->get(); // Obtiene todos los registros de actividad, ordenados por los más recientes.
        return view('admin.audit_log', compact('activities'));
    }

    
}
