<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $notifications = auth()->user()->unreadNotifications;
        dispatch(function () use ($notifications) {
            $notifications->markAsRead();
        })->afterResponse();
        return response()->json(['notifications' => $notifications]);
    }
}
