<?php


namespace App\Gateways;


use App\Interfaces\GatewayInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use function PHPUnit\Framework\throwException;

class IranKish extends GatewayInterface
{
    private $merchantId, $baseUrl, $acceptorId, $password, $publicKey;
    public $isRial = true;

    public function __construct()
    {
        $this->merchantId = config('gateway.IranKish.merchant_id');
        $this->baseUrl = config('gateway.IranKish.base_url');
        $this->id = config('gateway.IranKish.id');
        $this->acceptorId = config('gateway.IranKish.acceptor_id');
        $this->password = config('gateway.IranKish.password');
        $this->publicKey = config('gateway.IranKish.pub_key');
    }

    function gatewayUrl(): string
    {
        return "https://ikc.shaparak.ir/iuiv3/IPG/Index/";
    }

    function onReturn($payment, $request)
    {
        if (!$request->token || $request->token == "") {
            return false;
        }

        if ($request->responseCode != "00") {
            return false;
        }

        $payload = [
            "terminalId" => $this->merchantId,
            "retrievalReferenceNumber" => $request->retrievalReferenceNumber,
            "systemTraceAuditNumber" => $request->systemTraceAuditNumber,
            "tokenIdentity" => $request->token,
        ];

        try {
            $jsonData = json_encode($payload);
            $response = Http::withOptions([
                'curl' => [CURLOPT_SSL_CIPHER_LIST => 'DEFAULT@SECLEVEL=1']
            ])->withHeaders([
                'Content-Type' => 'application/json',
                "Content-Length" => strlen($jsonData)
            ])
                ->withBody($jsonData, 'application/json')
                ->post("$this->baseUrl/api/v3/confirmation/purchase")->throw()->json();
            if ($response['status'] != false) {
                return $request->retrievalReferenceNumber;
            }
            return abort("500", "Problem occurred with IranKish Gateway! " . $response['description']);
        } catch (RequestException $exception) {
            return abort(500, $exception->getMessage());
        }
    }

    function postParameters(): array
    {
        return ['tokenIdentity' => $this->token];
    }

    public function method()
    {
        return "POST";
    }

    protected function getToken()
    {
        if ($this->token) {
            return $this->token;
        }
        $requestData = [];
        $requestData['request'] = [
            "acceptorId" => $this->acceptorId,
            "amount" => $this->order->total * 10,
            "billInfo" => null,
            "paymentId" => null,
            "requestId" => uniqid(),
            "requestTimestamp" => time(),
            "revertUri" => config('app.url') . "/payment/{$this->payment->id}",
            "terminalId" => $this->merchantId,
            "transactionType" => "Purchase",
        ];
        $requestData["authenticationEnvelope"] = $this->generateAuthenticationEnvelope();

        try {
            $jsonData = json_encode($requestData);
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                "Content-Length" => strlen($jsonData)
            ])
                ->withBody($jsonData, 'application/json')
                ->post("$this->baseUrl/api/v3/tokenization/make")->throw()->json();
            if ($response['responseCode'] == "00") {
                $this->token = $response['result']['token'];
                return $this->token;
            }
            return abort("500", "Problem occurred with IranKish Gateway! " . $response['responseCode'] . " " . $response['description']);
        } catch (RequestException $exception) {
            return abort(500, $exception->getMessage());
        }
    }

    private function generateAuthenticationEnvelope()
    {
        $data = $this->merchantId . $this->password . str_pad($this->payment->amount, 12, '0', STR_PAD_LEFT) . '00';
        $data = hex2bin($data);
        $AESSecretKey = openssl_random_pseudo_bytes(16);
        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($data, $cipher, $AESSecretKey, $options = OPENSSL_RAW_DATA, $iv);
        $hmac = hash('sha256', $ciphertext_raw, true);
        $cryptText = '';

        openssl_public_encrypt($AESSecretKey . $hmac, $cryptText, $this->publicKey);

        return array(
            "data" => bin2hex($cryptText),
            "iv" => bin2hex($iv),
        );
    }
}