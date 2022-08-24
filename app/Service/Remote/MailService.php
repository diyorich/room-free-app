<?php

namespace App\Service\Remote;

class MailService
{
    const RAPID_KEY = RAPID_API_KEY;
    const RAPID_HOST = RAPID_HOST;

    public function sendMail($mailAddress, $messageTitle, $messageBody)
    {
        $rapidKey = self::RAPID_KEY;
        $rapidHost = self::RAPID_HOST;

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://{$rapidHost}/mail/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{
                \"personalizations\": [
            {
            \"to\": [
                {
                    \"email\":                    \"$mailAddress\"
                }
            ],
            \"subject\": \"$messageTitle\"
            }
            ],
            \"from\": {
         \"email\": \"from_address@example.com\"
            },
            \"content\": [
            {
            \"type\": \"text/plain\",
            \"value\": \"$messageBody\"
            }
        ]
            }",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: {$rapidHost}",
                "X-RapidAPI-Key: {$rapidKey}",
                "content-type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }
}
