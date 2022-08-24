<?php

namespace Views\cmd;

class WelcomeShow extends BaseShow
{
    public function showGreetingMessage()
    {
        $greetingMessage = "Welcome to room reserver app \nPress any key to continue or Ctrl+C to quit";
        $this->showMessage($greetingMessage, true);
    }
}
