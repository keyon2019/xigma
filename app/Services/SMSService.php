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
    private $username, $password, $url, $sourceNumber;

    public function __construct()
    {
        $this->username = config('sms.username');
        $this->password = config('sms.password');
        $this->url = "https://rest.payamak-panel.com/api/SendSMS/SendSMS";
        $this->sourceNumber = "9999554615";
    }

    public function send($mobile, $content)
    {
        try {
            Http::post($this->url, [
                "username" => $this->username,
                "password" => $this->password,
                "to" => $mobile,
                "from" => $this->sourceNumber,
                "text" => $content
            ]);
            return true;
        } catch (\Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }
}