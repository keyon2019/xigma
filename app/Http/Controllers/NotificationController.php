<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return response()->json(auth()->user()->unreadNotifications);
    }

    public function read(DatabaseNotification $notification)
    {
        $notification->delete();
        return response([], 200);
    }
}
