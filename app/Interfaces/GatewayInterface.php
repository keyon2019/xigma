<?php


namespace App\Interfaces;

abstract class GatewayInterface
{
    public $id, $order, $payment, $token;
    public $isRial = false;

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
            'amount' => $this->isRial ? $order->total * 10 : $order->total,
            'gateway' => $this->id
        ]);
        $this->payment->update(['token' => $this->getToken()]);
        return $this;
    }

    public function updateToken($order, $payment)
    {
        $this->order = $order;
        $this->payment = $payment;
        $this->payment->update(['token' => $this->getToken()]);
        return $this;
    }
}