<?php

namespace App\Class;

use App\NotifierInterface;

class MailSender implements NotifierInterface
{
    public function send(string $to, string $message): void
    {
        // メール送信ロジックを記述
    }
}
