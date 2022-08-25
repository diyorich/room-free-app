<?php

namespace App\Service\Remote;

class SmsService
{
    const SMS_SERVICE_BASE_URL = 'https://api.txtlocal.com/send/';

    public function sendSms(int $number, string $body)
    {
    }
}