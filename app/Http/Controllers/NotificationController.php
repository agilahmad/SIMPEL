<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $notifications = auth()->user()->notifications()->latest()->paginate(20);

        $stats = [
            'total'          => $user->notifications()->count(),
            'unread'         => $user->unreadNotifications()->count(),
            'read'           => $user->notifications()->whereNotNull('read_at')->count(),
            'community_new'  => $user->notifications()
                                    ->whereJsonContains('data->type', 'community_report_new')
                                    ->count(),
        ];

        return view('notifications.index', compact('notifications'));
    }

    public function read(string $id)
    {
       $notification = auth()->user()
            ->notifications()
            ->findOrFail($id);

        $notification->markAsRead();

        return response()->json([
            'redirect_url' => $notification->data['url'] ?? route('dashboard'),
        ]);
    }

    public function readAll()
    {
        auth()->user()->unreadNotifications()->update(['read_at' => now()]);

        return response()->json(['message' => 'Semua notifikasi ditandai dibaca.']);
    }

    public function poll(){
        $user          = auth()->user();
        $unreadCount   = cache()->remember("user:{$user->id}:unread_count", now()->addSeconds(10), fn () => $user->unreadNotifications()->count());
        $notifications = $user->notifications()->latest()->take(10)->get();

        return response()->json([
            'unread_count'  => $unreadCount,
            'notifications' => NotificationResource::collection($notifications),
        ]);
    }
}
