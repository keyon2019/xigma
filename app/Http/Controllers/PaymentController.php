<?php

namespace App\Http\Controllers;

use App\Events\OrderPaid;
use App\Models\Order;
use App\Models\Payment;
use App\Services\SMSService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function store(Order $order)
    {

    }

    public function update(Payment $payment, Request $request, SMSService $SMSService)
    {
        if ($reference_number = $payment->gateway->onReturn($payment, $request)) {
            $payment->update([
                'reference_number' => $reference_number,
                'successful' => true
            ]);

            event(new OrderPaid($payment->order));

            $SMSService->send($payment->order->user->mobile, "{$payment->order->user->name};{$payment->order->id}", SMSService::ORDER_PLACED);

            return redirect("/order/$payment->order_id")->with(['flash_message' => json_encode(['message' => 'پرداخت با موفقیت انجام شد', 'type' => 'success'])]);
        }
        return redirect("/order/$payment->order_id")->with(['flash_message' => json_encode(['message' => 'خطا در عملیات پرداخت', 'type' => 'danger'])]);
    }
}
