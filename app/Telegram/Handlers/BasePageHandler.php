<?php

namespace App\Telegram\Handlers;

abstract class BasePageHandler
{
    protected $bot;
    protected $page;
    protected $status = false;

    public function page($user_page, $callback): void
    {
        if ($this->page == $user_page and !$this->status) {
            $class = new $callback();
            $class($this->bot);
            $this->status = true;
        }
    }
}
