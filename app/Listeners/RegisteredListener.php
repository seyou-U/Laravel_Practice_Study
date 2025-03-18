<?php

namespace App\Listeners;

use App\Jobs\SendRegistMail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RegisteredListener
{
    private $mailer;
    private $eloquent;

    /**
     * コンストラクタ
     *  @param Mailer $mailer
     *  @param User $eloquent
     *  @return void
     */
    public function __construct(Mailer $mailer, User $eloquent)
    {
        $this->mailer = $mailer;
        $this->eloquent = $eloquent;
    }

    /**
     * イベント発生時のメソッド
     *  @param Registered $event
     *
     */
    public function handle(Registered $event): void
    {
        // user->getAuthIdentifier()は、$this->idと言い換えることもできる
        // $user = $this->eloquent->findOrFail($event->user->getAuthIdentifier());
        // $this->mailer->raw('会員登録が完了しました', function($message) use ($user) {
        //     $message->subject('会員登録メール')->to($user->email);
        // });

        // メール送信のジョブでキューにmailを指定し、実行時間を1時間遅らせる
        dispatch(new SendRegistMail($event->user->email))
            ->onQueue('mail')
            ->delay(now()->addHour(1));
    }
}
