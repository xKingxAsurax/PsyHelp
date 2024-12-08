<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json($notifications);
    }

    public function markAsRead(Notification $notification)
    {
        $notification->update(['read' => true]);
        return response()->json(['success' => true]);
    }
} 