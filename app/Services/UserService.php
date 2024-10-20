<?php

namespace App\Services;

use App\Class\MailSender;
use App\Repositories\Student\StudentRepositoryInterface;

class UserService
{
    /**
     * 利用者に対する通知操作を受け持つクラス
     * MailSenderクラスに依存している / 引数にインスタンスを渡すことでMailSenderクラスのメソッドも利用できるようにする
     */
    public function sendNotification(MailSender $mailSender, string $to, string $message): void
    {
        $mailSender->send($to, $message);
    }
}
