<?php

namespace App\Http\Controllers;

use App\Enum\Role;
use App\Models\Contact;
use App\Models\User;
use App\Notifications\ContactUsSubmitted;
use App\Rules\Mobile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('index');
    }

    public function index(Request $request)
    {
        Gate::authorize('edit-user');
        if ($request->wantsJson())
            return response()->json(Contact::latest()->paginate(15));
        return view('dashboard.contact.index');
    }

    public function show()
    {
        return view('website.contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'mobile' => ['required', new Mobile()],
            'title' => 'required|string',
            'content' => 'required|string'
        ]);

        Contact::create($validated);
        Notification::send(User::adminAndRoles(Role::SUPPORT)->get(), new ContactUsSubmitted());
        return response([]);
    }
}
