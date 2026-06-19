<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use App\Models\Alert;
use App\Models\AlertThreshold;
use App\Models\ActivityLog;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Dashboard', [
            'totalUsers' => User::count(),
            'totalPatients' => Patient::count(),
            'activeAlerts' => Alert::where('is_active', true)->count(),
            'totalThresholds' => AlertThreshold::count(),
            'recentActivity' => ActivityLog::with('user:id,name,role')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get(),
        ]);
    }
}
