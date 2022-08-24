<?php

namespace Views\cmd;

class GoodByeShow extends BaseShow
{
    public function byeShow()
    {
        $message = "Thanks for using room reserving application";
        $this->showMessage($message);
    }
}
