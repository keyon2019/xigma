<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->only('all');
    }

    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return response()->json(auth()->user()->reminders()->with('variation.product')->latest()->paginate(15));
        }
        return view('website.reminder.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'variation_id' => 'required|numeric|exists:variations,id'
        ]);
        if (auth()->user()->reminders()->whereVariationId($request->variation_id)->exists()) {
            return abort(400, "یادآور موجودی این محصول قبلا ثبت شده است");
        }
        auth()->user()->reminders()->create(['variation_id' => $request->variation_id]);
        return response([]);
    }

    public function destroy(Reminder $reminder)
    {
        if ($reminder->user_id != auth()->id())
            abort(401, "Unauthorized");
        $reminder->delete();
        return back()->with(['flash_message' => json_encode(['message' => 'درخواست یادآوری با موفقیت حذف شد', 'type' => 'success'])]);
    }
}
