<?php

namespace Views\Cmd;

use App\Controller\RoomsController;

class RoomsShow extends BaseShow
{
    protected $roomController;

    public function __construct()
    {
        $this->roomController = new RoomsController();
    }

    public function showAllRooms($rooms)
    {
        foreach ($rooms as $room) {
            echo " [Room " . $room['id'] . "] ";
        }
    }

    private function getReserveDate()
    {
        //Todo add validations for dateTime inputs like 2022-07-07 13:00
        $message = "Application checks if room is available for requested date. \nPlease enter date to reserve room (e.g 2022-08-24)";
        $validatedData = $this->showMessage($message, true);

        if (!strtotime($validatedData)) {
            $errorMessage = "Please enter date in correct format. Example 2022-07-08";
            $this->showMessage($errorMessage);
            $this->getReserveDate();
        }

        $todayDate = date('Y-m-d');

        if (strtotime($todayDate) > strtotime($validatedData)) {
            $errorMessage = "Set the date which is greater than now";
            $this->showMessage($errorMessage);
            $this->getReserveDate();
        }

        return $validatedData;
    }

    private function getReserveTime()
    {
        //TODO add validations for time
        $timeMessage = "Enter time when you gonna reserve it (e.g. 14:00)";
        $validatedTime = $this->showMessage($timeMessage, true);

        return $validatedTime;
    }

    private function getReserveDuration()
    {
        $durationMessage = "Enter duration of your reserve in HOURS (e.g 2)";
        $validatedDuration = $this->showMessage($durationMessage, true);

        if ($validatedDuration == '' || $validatedDuration < 1) {
            $message = "SET DURATION HOURS SHOULD BE GREATER THAN 0";
            $this->showMessage($message);
            $this->getReserveDuration();
        }

        if (!is_int(intval($validatedDuration))) {
            $this->getReserveDuration();
        }
        return $validatedDuration;
    }

    private function getMailBox()
    {
        //TODO add validation for MailBox name
        $mailMessage = "Enter mailBox of reserver (e.g example@gmail.com)";
        return $this->showMessage($mailMessage, true);
    }

    private function getReserverName()
    {
        //TODO be prepared for injections
        $message = "Enter your name:";
        $name = $this->showMessage($message, true);

        if ($name == '') {
            $this->getReserverName();
        }
        return $name;
    }

    public function takeRoomDataToCheck(int $roomId)
    {
        $reserverName = $this->getReserverName();
        $date = $this->getReserveDate();
        $timeStartReserve = $this->getReserveTime();
        $reserveDuration = $this->getReserveDuration();
        $mailBox = $this->getMailBox();

        $reserveStart = $date . ' ' . $timeStartReserve;

        $reserveEnd = date('Y-m-d H:i', strtotime($reserveStart. " + {$reserveDuration} hours"));

        $reserveInfo = [
            'reserveStart' => $reserveStart,
            'reserveEnd' => $reserveEnd,
            'roomId' => $roomId,
            'reservedBy' => $reserverName,
            'reserverMail' => $mailBox
        ];
        return $reserveInfo;
    }

    public function checkRoom(int $roomId)
    {
        var_dump('fuck');
        $reserveInfo = $this->takeRoomDataToCheck($roomId);
        $roomIsBusy = $this->roomController->checkRoomIsFree($reserveInfo);

        if ($roomIsBusy) {
            $message = "Room {$roomIsBusy['room_id']} is reserved by {$roomIsBusy['reserved_by']}\n" .
                "from {$roomIsBusy['r_from']} to {$roomIsBusy['r_to']}";
            return $this->showMessage($message);
        }

        $answer = $this->showMessage('Room is free would you like to reserve it? (y/n)', true);
        $this->confirmReserve($answer, $reserveInfo);
    }

    public function confirmReserve(string $answer, array $reserveInfo)
    {
        if ($answer == 'y' || $answer == "Y") {
            $response = $this->roomController->reserveRoom($reserveInfo);
            $message = "Room is successfully reserved.\n" .
                        "Your token is $response \n" .
                        "If you want to get confirmation by email\n" .
                        "enter command ' -send-notification [your token]' to get confirmation message";

            $this->showMessage($message);
        }
    }

    public function sendNotification($token)
    {
        $this->roomController->sendNotification($token);
        $message = "Notification successfully sent to user";
        return $this->showMessage($message);
    }
}
