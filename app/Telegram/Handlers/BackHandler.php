<?php

namespace App\Telegram\Handlers;

use App\Models\BotUser;
use SergiX44\Nutgram\Nutgram;

class BackHandler
{
    public function __invoke(Nutgram $bot, $page): void
    {
        switch ($page) {

        }
    }
}
