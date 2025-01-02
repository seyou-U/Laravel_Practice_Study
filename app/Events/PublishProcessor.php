<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
// websocketを使ってブラウザにイベント通知する際に利用する
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
// イベントクラスにDispatcherとして利用させる際に利用する
use Illuminate\Foundation\Events\Dispatchable;
// キュート組み合わせて非同意イベントを実行する時に利用する
use Illuminate\Queue\SerializesModels;

final class PublishProcessor
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    private $int;

    /**
     * Create a new event instance.
     */
    public function __construct(int $int)
    {
        $this->int = $int;
    }

    /**
     * インスタンス生成時、引数として渡した数字を返却する
     *
     * @return int
     */
    public function getInt(): int
    {
        return $this->int;
    }
}
