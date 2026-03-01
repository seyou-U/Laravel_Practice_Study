<?php

namespace App\Events;

use App\Models\Memo;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MemoCreated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    /**
     * コンストラクタの作成
     */
    public function __construct(public Memo $memo) {}

    /**
     * 公開チャンネルの指定
     * @return Channel
     */
    public function broadcastOn():Channel
    {
        return new Channel('memos');
    }

    /**
     * イベント名の指定
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'MemoCreated';
    }

    /**
     * フロントに渡すデータの指定
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->memo->id,
            'title' => $this->memo->title,
        ];
    }

}
