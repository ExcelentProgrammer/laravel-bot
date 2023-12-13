<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use SergiX44\Nutgram\Nutgram;

class BotController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Nutgram $bot): void
    {
        try {
            $bot->run();
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
            Log::error($e->getMessage());
        }
    }
}
