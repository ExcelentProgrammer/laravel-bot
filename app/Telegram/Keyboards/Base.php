<?php

namespace App\Telegram\Keyboards;

use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;

class Base
{
    public InlineKeyboardMarkup $diary;
    public InlineKeyboardMarkup $grades;
    public ReplyKeyboardMarkup $home;
    public InlineKeyboardMarkup $quarters;
    public InlineKeyboardMarkup $schedules;

    public function __construct()
    {
        $this->diary = InlineKeyboardMarkup::make()->addRow(
            InlineKeyboardButton::make(__("grades"), callback_data: "account:grades"),
            InlineKeyboardButton::make(__("schedule"), callback_data: "account:schedule")
        )->addRow(
            InlineKeyboardButton::make(__("quarter"), callback_data: "account:quarter"),
            InlineKeyboardButton::make(__("rating"), callback_data: "account:rating")
        )->addRow(
            InlineKeyboardButton::make(__("information"), callback_data: "account:information")
        )->addRow(
            InlineKeyboardButton::make(__("back"), callback_data: "back:select_account")
        );


        $this->grades = InlineKeyboardMarkup::make()->addRow(
            InlineKeyboardButton::make(__("grades:daily"), callback_data: "grades:daily"),
            InlineKeyboardButton::make(__("grades:weekly"), callback_data: "grades:weekly")
        )->addRow(
            InlineKeyboardButton::make(__("back"), callback_data: "back:diary")
        );

        $this->schedules = InlineKeyboardMarkup::make()->addRow(
            InlineKeyboardButton::make("Bugun", callback_data: "schedule:today"),
            InlineKeyboardButton::make("Haftalik", callback_data: "schedule:weekly"),
            InlineKeyboardButton::make("Ertaga", callback_data: "schedule:tomorrow"),
        )->addRow(
            $this->back_inline_button("diary")
        );

        $this->quarters = InlineKeyboardMarkup::make()->addRow(
            InlineKeyboardButton::make("1-chorak", callback_data: "quarter:1"),
            InlineKeyboardButton::make("2-chorak", callback_data: "quarter:2"),
        )->addRow(
            InlineKeyboardButton::make("3-chorak", callback_data: "quarter:3"),
            InlineKeyboardButton::make("4-chorak", callback_data: "quarter:4"),
        )->addRow($this->back_inline_button("diary"));

        $this->home = ReplyKeyboardMarkup::make(resize_keyboard: true)->addRow(
            KeyboardButton::make(__("kundalik"))
        )->addRow(
            KeyboardButton::make(__("settings"))
        );
    }

    function back($page): InlineKeyboardMarkup
    {
        return InlineKeyboardMarkup::make()->addRow(
            $this->back_inline_button($page)
        );
    }

    function back_inline_button($page): InlineKeyboardButton
    {
        return InlineKeyboardButton::make(__("back"), callback_data: "back:$page");
    }


    /**
     * @return ReplyKeyboardMarkup
     */
    function cancel(): ReplyKeyboardMarkup
    {
        return ReplyKeyboardMarkup::make(resize_keyboard: true)->addRow(
            KeyboardButton::make(__("cancel"))
        );
    }
}
