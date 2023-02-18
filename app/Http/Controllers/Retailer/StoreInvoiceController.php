<?php

namespace App\Http\Controllers\Retailer;

use App\Http\Controllers\Controller;
use App\Models\StoreInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StoreInvoiceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson())
            return response()->json(StoreInvoice::with('retailer')
                ->whereIn('retailer_id', auth()->user()->retailers->pluck('id')->toArray())->paginate(15));
        return view('retailer.invoice.index');
    }

    public function create()
    {
        return view('retailer.invoice.create')
            ->with('retailers', auth()->user()->retailers);
    }

    public function show(StoreInvoice $invoice)
    {
        return view('retailer.invoice.show')
            ->with('invoice', $invoice->load('variations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'retailer_id' => ['required', 'numeric', Rule::in(auth()->user()->retailers->pluck('id')->toArray())],
            'items' => 'required|array',
            'items.*.id' => 'required|numeric',
            'items.*.quantity' => 'required|numeric',
            'items.*.price' => 'required|numeric',
            'items.*.discount' => 'required|numeric',
        ]);
        $items = collect($request->items)->mapWithKeys(function ($item) use ($request) {
            return [$item['id'] => [
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'discount' => $item['discount']
            ]];
        });

        $invoice = DB::transaction(function () use ($request, $items) {
            $invoice = StoreInvoice::create(['retailer_id' => $request->retailer_id]);
            $invoice->variations()->attach($items);

            foreach ($items as $id => $item) {
                DB::table('stocks')->whereVariationId($id)
                    ->whereRetailerId($request->retailer_id)
                    ->decrement('quantity', $item['quantity']);
            }

            return $invoice;
        });
        return response()->json($invoice);
    }
}
