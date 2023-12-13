<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;

/**
 * @method static where(array $array)
 * @property mixed|string $first_name
 * @property mixed|string $last_name
 * @property mixed|string $username
 * @property mixed|string $user_id
 * @property mixed|string $page
 */
class BotUser extends Model
{
    use HasFactory;


    public $fillable = [
        "user_id",
        "username",
        "first_name",
        "last_name",
        "page"
    ];


    public function data(): HasMany
    {
        return $this->hasMany(UserData::class, "bot_user_id");
    }


    /**
     * @param $chat_id
     * @param $page
     * @return mixed
     * set user page
     */
    static function setPage($chat_id, $page): mixed
    {
        return self::where(['user_id' => $chat_id])->update(['page' => $page]);
    }


    /**
     * @param $chat_id
     * @return mixed
     * get user page
     */
    static function getPage($chat_id): mixed
    {
        return self::where(['user_id' => $chat_id])->first()->page;
    }

    /**
     * @param $chat_id
     * @param $key
     * @param $value
     * @return mixed
     * update user data
     */
    static function updateData($chat_id, $key, $value): mixed
    {
        return BotUser::where(['user_id' => $chat_id])->first()->data()->where(['key' => $key])->update(['value' => $value]);
    }

    /**
     * @param $chat_id
     * @param $key
     * @return mixed
     * get user data
     */
    static function getData($chat_id, $key): mixed
    {
        return BotUser::where(['user_id' => $chat_id])->first()->data()->where(['key' => $key])->first()?->value;
    }

    /**
     * @param $chat_id
     * @return mixed
     * get all user data
     */
    static function getAllData($chat_id): mixed
    {
        return BotUser::where(['user_id' => $chat_id])->first()->data;

    }

    /**
     * @param $chat_id
     * @param $key
     * @param $value
     * @return mixed
     * set user data
     */
    static function setData($chat_id, $key, $value): mixed
    {
        $res = self::getData($chat_id, $key);

        if (!empty($res)) {
            return self::updateData($chat_id, $key, $value);
        }
        return BotUser::where(['user_id' => $chat_id])->first()->data()->create(['key' => $key, "value" => $value]);
    }

    /**
     * @param $chat_id
     * @return mixed
     * clear user all data
     */
    static function clearData($chat_id): mixed
    {
        return BotUser::where(['user_id' => $chat_id])->first()->data()->delete();

    }
}


