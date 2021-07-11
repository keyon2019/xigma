<?php


namespace App\Interfaces;

abstract class GatewayInterface
{
    public $id, $order, $payment, $token;

    abstract function postParameters(): array;

    abstract function gatewayUrl(): string;

    abstract function onReturn($payment, $request);

    protected abstract function getToken();

    public function method()
    {
        return 'POST';
    }

    public function create($order): self
    {
        $this->order = $order;
        $this->payment = $this->order->payments()->create([
            'amount' => $order->total,
            'gateway' => $this->id
        ]);
        $this->payment->update(['token' => $this->getToken()]);
        return $this;
    }
}