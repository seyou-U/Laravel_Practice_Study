<?php

namespace App\Class;

use App\Interfaces\NotifierInterface;

class PushSender implements NotifierInterface
{
    public function send(string $to, string $message): void
    {
        // プッシュ通知ロジックを記述
    }
}
