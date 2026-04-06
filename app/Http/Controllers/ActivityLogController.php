<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function index(Request $request){
        abort_unless(Auth::user() && Auth::Admin(), 403, 'Unauthorized');

        $logs = ActivityLog::with('user')
            ->when($request->filled('event'), fn($q) => $q->where('event', $request->event))
            ->when($request->filled('user_id'), fn($q) => $q->where('user_id', $request->user_id))
            ->when($request->filled('date'), fn($q) => $q->whereDate('created_at', $request->date))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $events = ActivityLog::distinct()->pluck('event')->sort()->values();

        return view('activity_logs.index', compact('logs', 'events'));
    }
}
