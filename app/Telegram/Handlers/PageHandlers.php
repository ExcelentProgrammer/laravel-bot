<?php

namespace App\Telegram\Handlers;

use App\Models\BotUser;
use SergiX44\Nutgram\Nutgram;

class PageHandlers extends BasePageHandler
{

    public function __construct(Nutgram $bot)
    {
        $this->bot = $bot;
        $this->page = BotUser::getPage($this->bot->userId());
    }
}
