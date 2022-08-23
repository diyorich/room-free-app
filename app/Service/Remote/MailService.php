<?php

namespace App\Service\Remote;

class MailService
{
    public function sendMail($mailAddress, $messageTitle, $messageBody)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://rapidprod-sendgrid-v1.p.rapidapi.com/mail/send",
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
                "X-RapidAPI-Host: rapidprod-sendgrid-v1.p.rapidapi.com",
                "X-RapidAPI-Key: acf25cb88cmshe6aa40b94db6d56p1ac46fjsnb1587b115d73",
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