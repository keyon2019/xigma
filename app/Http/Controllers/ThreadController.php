<?php

namespace App\Http\Controllers;

use App\Filters\ThreadFilters;
use App\Filters\UserFilters;
use App\Models\Province;
use App\Models\Thread;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->except('show', 'userThreads');
    }

    public function index(Request $request, ThreadFilters $threadFilters)
    {
        if ($request->wantsJson())
            return response()->json(Thread::filter($threadFilters)->with('user')->orderBy('updated_at', 'desc')
                ->paginate(15));
        return view('dashboard.thread.index');
    }

    public function userThreads(Request $request)
    {
        if ($request->wantsJson())
            return response()->json(auth()->user()->threads()->orderBy('updated_at', 'desc')
                ->paginate(15));
        return view('website.thread.index');
    }

    public function create()
    {
        return view('dashboard.thread.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string',
            'repliable' => 'boolean'
        ]);

        $thread = Thread::create($validated);
        return redirect("/dashboard/thread/$thread->id")
            ->with(['flash_message' => json_encode(['message' => 'پیغام با موفقیت ارسال شد', 'type' => 'success'])]);
    }

    public function show(Thread $thread)
    {
        if ($thread->user_id != auth()->id())
            abort(401, "Unauthenticated!");
        if (!$thread->seen) {
            $thread->update(['seen' => true]);
        }
        $thread->load('replies.user');
        return view('website.thread.show', compact('thread'));
    }

    public function edit(Thread $thread)
    {
        $thread->load('replies.user');
        return view('dashboard.thread.edit', compact('thread'));
    }

    public function bulk()
    {
        return view('dashboard.thread.bulk')
            ->with('vehicles', Vehicle::all())
            ->with('provinces', Province::all());
    }

    public function storeBulk(Request $request, UserFilters $userFilters)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'message' => 'required|string',
            'repliable' => 'boolean',
            'vehicle' => 'nullable|numeric|exists:vehicles,id',
            'province' => 'nullable|numeric|exists:provinces,id'
        ]);

        $userIds = User::filter($userFilters)->pluck('id');

        $threads = $userIds->map(function ($userId) use ($validated, $request) {
            return [
                'title' => $validated['title'],
                'repliable' => $request->repliable ? $validated['repliable'] : false,
                'message' => $validated['message'],
                'user_id' => $userId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        });

        Thread::insert($threads->toArray());

        return redirect("/dashboard/thread")
            ->with(['flash_message' => json_encode(['message' => "پیغام با موفقیت برای {$threads->count()} کاربر ارسال شد", 'type' => 'success'])]);

    }
}
