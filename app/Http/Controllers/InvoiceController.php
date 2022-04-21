<?php

namespace App\Http\Controllers;

use App\Interfaces\CartInterface;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
        $invoice = auth()->user()->invoices()->create(['total' => $cart->totalPrice()]);
        $invoice->variations()->sync($cart->preparedForDB());
//        $cart->clear();
        return redirect("/invoice/$invoice->id");
    }

    public function print(Invoice $invoice)
    {
        if (auth()->user()->id === $invoice->user_id)
            return view('website.invoice.invoice')->with('invoice', $invoice->load('variations'));
        return abort(401);
    }
}
