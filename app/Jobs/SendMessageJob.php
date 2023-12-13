<?php

namespace App\Jobs;

use App\Models\BotUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

class SendMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public string $message;
    public mixed $keyboards;
    public mixed $file;
    public mixed $fileContent = null;
    public string $fileMime = "text";

    public function __construct(string $message, mixed $keyboards = null, $file = null)
    {
        $this->message = $message;
        $this->keyboards = $keyboards;
        $this->file = $file;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = BotUser::all();
        if ($this->file != null) {
            $this->fileContent = InputFile::make(Storage::readStream($this->file));
            $this->fileMime = explode("/", Storage::mimeType($this->file))[0];
        }

        $keyboard = null;
        if ($this->keyboards != null) {
            $keyboard = InlineKeyboardMarkup::make();

            foreach ($this->keyboards as $k) {
                $keyboard->addRow(
                    InlineKeyboardButton::make(text: $k['name'], url: $k['url'])
                );
            }
        }
        foreach ($users as $user) {
            try {
                $bot = new Nutgram(env("TELEGRAM_TOKEN"));
            } catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
                Log::error($e->getMessage());
                continue;
            }

            try {
                switch ($this->fileMime) {
                    case "text":
                        $bot->sendMessage(text: $this->message, chat_id: $user->user_id, reply_markup: $keyboard);
                        break;
                    case "image":
                        $bot->sendPhoto(photo: $this->fileContent, chat_id: $user->user_id, caption: $this->message, reply_markup: $keyboard);
                        break;
                    case "video":
                        $bot->sendVideo(video: $this->fileContent, chat_id: $user->user_id, caption: $this->message, reply_markup: $keyboard);
                        break;
                    case "audio":
                        $bot->sendAudio(audio: $this->fileContent, chat_id: $user->user_id, caption: $this->message, reply_markup: $keyboard);
                        break;
                }
            } catch (\Exception $e) {
                echo $e->getMessage() . ": $user->last_name $user->first_name\n\n";
            }
        }

        try {
            Storage::delete($this->file);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
