<?php

namespace Views\cmd;

class BaseShow
{
    public function showMessage(string $message, $waitForResponse=false)
    {
        echo "\n______________________________\n";
        echo "$message \n";
        if ($waitForResponse) {
            $handle = fopen("php://stdin", "r");
            $line = fgets($handle);
            $response = trim($line);
            fclose($handle);
            return $response;
        }
    }
}
