<?php

namespace App\Http\Controllers;

use App\Events\OrderPaid;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function store(Order $order)
    {

    }

    public function update(Payment $payment, Request $request)
    {
        if ($reference_number = $payment->gateway->onReturn($payment, $request)) {
            $payment->update([
                'reference_number' => $reference_number,
                'successful' => true
            ]);

            event(new OrderPaid($payment->order));

            return redirect("/order/$payment->order_id")->with(['flash_message' => json_encode(['message' => 'پرداخت با موفقیت انجام شد', 'type' => 'success'])]);
        }
        return redirect("/order/$payment->order_id")->with(['flash_message' => json_encode(['message' => 'خطا در عملیات پرداخت', 'type' => 'danger'])]);
    }
}
