<?php

namespace App\Http\Controllers;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = \App\Models\ActivityLog::with('user')->orderByDesc('created_at')->paginate(15);
        return view('activity-logs', compact('logs'));
    }
}