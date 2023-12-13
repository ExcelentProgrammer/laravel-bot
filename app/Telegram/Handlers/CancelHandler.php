<?php

namespace App\Telegram\Handlers;

use App\Models\BotUser;
use SergiX44\Nutgram\Nutgram;

class CancelHandler extends BaseHandler
{
    public function __invoke(Nutgram $bot): void
    {
        BotUser::setPage($bot->userId(), "home");
        $bot->sendMessage(__("home"), reply_markup: $this->keyboards->home);
    }
}
