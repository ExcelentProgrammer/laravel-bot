<?php

namespace App\Telegram\Handlers;

use App\Telegram\Keyboards\Base;

abstract class BaseHandler
{
    public Base $keyboards;

    function __construct()
    {
        $this->keyboards = new Base();
    }

}
