<?php


namespace App\Services;


use App\Models\Message;

class MessageService
{
    # hata burada db'ye kaydetmiyor.
    static function create($username, $message, $event_id)
    {

        return Message::create(['message' => $message,
            'username' => $username,
            'event_id' => $event_id]);
    }
}
