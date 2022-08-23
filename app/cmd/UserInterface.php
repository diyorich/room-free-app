<?php

namespace App\cmd;

interface UserInterface
{
    public function startDialog();

    public function stopDialog();
}
