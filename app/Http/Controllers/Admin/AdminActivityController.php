<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Inertia\Inertia;

class AdminActivityController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/ActivityLog/Index', [
            'logs' => ActivityLog::with('user:id,name,role')
                        ->orderBy('created_at', 'desc')
                        ->paginate(50),
        ]);
    }
}