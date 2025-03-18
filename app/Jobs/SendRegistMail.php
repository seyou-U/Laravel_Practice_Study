<?php

namespace App\Jobs;

use Carbon\Traits\Serialization;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Knp\Snappy\Pdf;

class SendRegistMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $path = '';

    /**
     * Create a new job instance.
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * handleメソッドの引数に型宣言を記述すると、サービスコンテナで定義したオブジェクトが渡される
     */
    public function handle($mail): void
    {
        // user->getAuthIdentifier()は、$this->idと言い換えることもできる
        $user = $this->eloquent->findOrFail($event->user->getAuthIdentifier());
        $this->mailer->raw('会員登録が完了しました', function($message) use ($user) {
            $message->subject('会員登録メール')->to($user->email);
        });
    }
}
