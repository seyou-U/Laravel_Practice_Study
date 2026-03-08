<?php

namespace App\Listeners;

use App\Events\MemoUpdated;
use Illuminate\Support\Facades\Log;

class WriteMemoUpdatedLog
{
    /**
     * メモが更新された際に、ログを残す
     */
    public function handle(MemoUpdated $event): void
    {
        Log::info('メモが更新されました', [
            'memo_id' => $event->memo->id,
            'user_id' => $event->user->id,
            'before' => $event->before,
            'after' => $event->after,
        ]);
    }
}
