<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\GoogleAnalyticsService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(Request $request, GoogleAnalyticsService $analytics): Response
    {
        $rangeDays = (int) $request->integer('range', 30);
        $rangeDays = in_array($rangeDays, [7, 30, 90], true) ? $rangeDays : 30;

        return Inertia::render('dashboard', [
            'analytics' => $analytics->dashboard($rangeDays),
            'filters' => [
                'range' => $rangeDays,
                'ranges' => [7, 30, 90],
            ],
        ]);
    }
}
