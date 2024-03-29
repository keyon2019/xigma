<?php

namespace App\Http\Controllers;

use App\Filters\InvoiceFilters;
use App\Interfaces\CartInterface;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function all(Request $request, InvoiceFilters $filters)
    {
        Gate::authorize('edit-invoice');
        if ($request->wantsJson())
            return response()->json(Invoice::filter($filters)->with('user')->latest()->paginate(15));
        return view('dashboard.invoice.index');
    }

    public function edit(Invoice $invoice)
    {
        Gate::authorize('edit-invoice');
        return view('dashboard.invoice.edit')
            ->with('invoice', $invoice->load(['user', 'variations.product']));
    }

    public function index(Request $request)
    {
        if ($request->wantsJson())
            return response()->json(auth()->user()->invoices()->latest()->paginate(10));
        return view('website.invoice.index');
    }

    public function show(Invoice $invoice)
    {
        if ($invoice->user_id == auth()->id())
            return view('website.invoice.show', compact('invoice'));
        return abort(403, "You don't own this invoice");
    }

    public function store(CartInterface $cart)
    {
        $total = $cart->totalPrice();
        $vat = round($total * 0.1);
        $invoice = auth()->user()->invoices()->create([
            'total' => $cart->totalPrice() + $vat,
            'vat' => $vat
        ]);
        $invoice->variations()->sync($cart->preparedForDB());
        $cart->clear();
        return redirect("/invoice/$invoice->id");
    }

    public function print(Invoice $invoice)
    {
        if (auth()->user()->id === $invoice->user_id)
            return view('website.invoice.invoice')->with('invoice', $invoice->load('variations'));
        return abort(401);
    }
}
