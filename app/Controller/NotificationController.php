<?php

namespace App\Controller;

use App\Service\NotificationService;

class NotificationController
{
    protected $notificationService;

    public function __construct()
    {
        $this->notificationService = new NotificationService();
    }
    public function sendNotification(string $token): void
    {
        $this->notificationService->sendNotification($token);
    }
}