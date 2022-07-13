<?php
/**
 * Created by PhpStorm.
 * User: arman
 * Date: 4/30/22
 * Time: 3:33 PM
 */

namespace App\Services;


use Illuminate\Support\Facades\Http;

class SMSService
{
    private $username, $password, $url;

    CONST OTP = 92182;
    CONST ORDER_PLACED = 91914;

    public function __construct()
    {
        $this->username = config('sms.username');
        $this->password = config('sms.password');
        $this->url = "https://rest.payamak-panel.com/api/SendSMS/BaseServiceNumber";
    }

    public function send($mobile, $content, $templateId)
    {
        try {
            Http::post($this->url, [
                "username" => $this->username,
                "password" => $this->password,
                "to" => $mobile,
                "bodyId" => $templateId,
                "text" => $content
            ]);
            return true;
        } catch (\Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }
}