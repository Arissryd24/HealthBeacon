<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use Inertia\Inertia;

class AlertController extends Controller
{
    public function index()
    {
        $alerts = Alert::with('patient')
            ->orderBy('triggered_at', 'desc')
            ->paginate(20);

        return Inertia::render('Alerts/Index', [
            'alerts' => $alerts,
        ]);
    }

    public function resolve(Alert $alert)
    {
        $alert->update([
            'is_active'   => false,
            'resolved_at' => now(),
        ]);

        return back();
    }
}