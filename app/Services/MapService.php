<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MapService
{
    protected $token, $url;

    public function __construct()
    {
        $this->token = config('map.token');
        $this->url = config('map.url');
    }

    public function search($keyword)
    {
        try {
            $response = Http::withHeaders(['x-api-key' => $this->token])
                ->post('https://map.ir/search/v2', [
                    'text' => $keyword
                ]);
            $result = $response->json();
            if (!$response->successful()) {
                throw new \Exception($result['message']);
            }
            return $result['value'];
        } catch (\Exception $e) {
            return abort(402, $e->getMessage());
        }
    }
}