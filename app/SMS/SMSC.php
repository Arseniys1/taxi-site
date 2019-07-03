<?php

namespace App\SMS;

use GuzzleHttp;

class SMSC
{
    private $guzzleClient;
    private $url = 'https://smsc.ru/sys/send.php';

    /**
     * SMSC constructor.
     */
    public function __construct()
    {
        $this->guzzleClient = new GuzzleHttp\Client();
    }

    public function send($phone_number, $data) {
        $params = [
            'login' => env('SMSC_LOGIN'),
            'psw' => env('SMSC_PASSWORD'),
            'phones' => $phone_number,
            'mes' => $data,
            'fmt' => 3,
        ];

        $params = http_build_query($params);

        $response = $this->guzzleClient->get($this->url . '?' . $params);

        $body = json_decode($response->getBody(), true);

        return $body;
    }
}