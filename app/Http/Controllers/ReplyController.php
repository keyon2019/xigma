<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\User;
use App\Notifications\ThreadReplied;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Thread $thread, Request $request)
    {
        if (auth()->user()->is_admin || auth()->id() == $thread->user_id) {
            $request->validate(['message' => 'required|string']);
            $thread->replies()->create([
                'message' => $request->message,
                'user_id' => auth()->id()
            ]);
            if (auth()->id() == $thread->user_id) {
                Notification::send(User::adminAndRoles()->get(), new ThreadReplied($thread));
            }
            return back()->with(
                ['flash_message' => json_encode(['message' => 'پاسخ شما با موفقیت ثبت شد', 'type' => 'success'])]
            );
        }
        return abort(401, "Unauthorized");
    }
}
