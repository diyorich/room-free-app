<?php

namespace App\Service;

use App\Models\Notification;
use App\Service\Remote\MailService;

class NotificationService
{
    public function sendNotification(string $token)
    {
        $notification = new Notification();

        $receiverData = $notification->getReserveData($token)[0];
        $receiverMail = $receiverData['mail'];
        $receiverRoom = $receiverData['room_id'];
        $reserveStart = $receiverData['r_from'];
        $reserveEnd = $receiverData['r_to'];

        $mailTitle = "Room #{$receiverRoom} reserved";
        $mailBody = "You received this mail because you reserved room #{$receiverRoom} from : {$reserveStart} to : {$reserveEnd}";
        $mailService = new MailService();
        $mailService->sendMail($receiverMail, $mailTitle,$mailBody);
    }
}
