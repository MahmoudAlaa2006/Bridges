<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    public function index(): JsonResponse
    {
        $notifications = Notification::all();
        return response()->json($notifications);
    }

    public function indexByUser(string $userId): JsonResponse
    {
        $notifications = Notification::where('recipient_id', $userId)->get();
        return response()->json($notifications);
    }

    public function show(string $notificationId): JsonResponse
    {
        $notification = Notification::find($notificationId);

        if (!$notification) {
            return response()->json(['error' => 'Notification not found'], 404);
        }

        return response()->json($notification);
    }

    public function markAsRead(string $notificationId): JsonResponse
    {
        $notification = Notification::find($notificationId);

        if (!$notification) {
            return response()->json(['error' => 'Notification not found'], 404);
        }

        $notification->markRead();
        return response()->json(['message' => 'Notification marked as read']);
    }

    public function markAllAsRead(string $userId): JsonResponse
    {
        Notification::where('recipient_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['message' => 'All notifications marked as read']);
    }

    public function markMineAsRead(): JsonResponse
    {
        Notification::where('recipient_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true, 'message' => 'Your notifications are marked as read']);
    }

    /**
     * Return the current user's notifications newest-first.
     */
    public function myList(): JsonResponse
    {
        $notifications = Notification::where('recipient_id', auth()->id())
            ->orderByDesc('created_at')
            ->limit(30)
            ->get(['notification_id', 'subject', 'message', 'type', 'read_at', 'created_at']);

        return response()->json($notifications);
    }

    /**
     * Return the count of unread notifications for the current user.
     */
    public function unreadCount(): JsonResponse
    {
        $count = Notification::where('recipient_id', auth()->id())
            ->whereNull('read_at')
            ->count();

        return response()->json(['count' => $count]);
    }

    public function getUnread(string $userId): JsonResponse
    {
        $notifications = Notification::where('recipient_id', $userId)
            ->whereNull('read_at')
            ->get();

        return response()->json($notifications);
    }

    public function send(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'recipient_id' => 'required|string',
            'subject' => 'required|string',
            'message' => 'required|string',
            'type' => 'required|string',
        ]);

        $notification = Notification::create([
            'notification_id' => \Illuminate\Support\Str::uuid(),
            'recipient_id' => $validated['recipient_id'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'type' => $validated['type'],
            'created_at' => now(),
        ]);

        return response()->json(['message' => 'Notification sent successfully', 'notification' => $notification], 201);
    }
}
