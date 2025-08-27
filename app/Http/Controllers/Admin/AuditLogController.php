<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class AuditLogController extends Controller
{
    public function showAuditLog(){

        $activities = Activity::latest()->get(); // Obtiene todos los registros de actividad, ordenados por los más recientes.
        return view('admin.audit_log', compact('activities'));
    }
}
