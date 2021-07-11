<?php


namespace App\Gateways;


use App\Interfaces\GatewayInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use function PHPUnit\Framework\throwException;

class Zarrinpal extends GatewayInterface
{
    private $merchantId, $baseUrl;

    public function __construct()
    {
        $this->merchantId = config('gateway.Zarrinpal.merchant_id');
        $this->baseUrl = config('gateway.Zarrinpal.base_url');
        $this->id = config('gateway.Zarrinpal.id');
    }

    function gatewayUrl(): string
    {
        return "$this->baseUrl/StartPay/{$this->getToken()}";
    }

    function onReturn($payment, $request)
    {
        try {
            $response = Http::post("$this->baseUrl/rest/WebGate/PaymentVerification.json", [
                'MerchantID' => $this->merchantId,
                'Authority' => $payment->token,
                'Amount' => $payment->amount
            ])->throw()->json();

            if ($response['Status'] == 101) {
                return $response['RefID'];
            }
            return false;
        } catch (RequestException $exception) {
            return false;
        }
    }

    function postParameters(): array
    {
        return [];
    }

    public function method()
    {
        return "GET";
    }

    protected function getToken()
    {
        if ($this->token) {
            return $this->token;
        }
        try {
            $response = Http::post("$this->baseUrl/rest/WebGate/PaymentRequest.json", [
                'MerchantID' => $this->merchantId,
                'Amount' => $this->order->total,
                'CallbackURL' => config('app.url') . "/payment/{$this->payment->id}",
                'Description' => 'Xigma'
            ])->throw()->json();
            if ($response['Status'] == 100) {
                $this->token = $response['Authority'];
                return $this->token;
            }
            abort("500", "Problem occurred with Zarinpal Gateway!");
        } catch (RequestException $exception) {
            abort(500, $exception->getMessage());
        }
    }
}