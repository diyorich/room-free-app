<?php

namespace Views;

use Views\Cmd\RoomsShow;
use Views\cmd\WelcomeShow;

class FrontTerminalApplication
{
    protected $greetingShow;

    protected $roomsShow;

    public function __construct()
    {
        $this->greetingShow = new WelcomeShow();
        $this->roomsShow = new RoomsShow();
    }
    public function start()
    {
        $this->greetingShow->showGreetingMessage();
        while (true) {
            $this->roomsShow->showRoomList();
        }
    }
}
