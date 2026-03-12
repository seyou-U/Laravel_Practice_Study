<?php

namespace App\Console\Commands;

use App\Models\Memo;
use Illuminate\Console\Command;

class DeleteAllMemos extends Command
{
    /**
     * コマンド名
     *
     * @var string
     */
    protected $signature = 'memo:delete-all';

    /**
     * コマンドの説明
     *
     * @var string
     */
    protected $description = '全てのメモを削除する';

    /**
     * 実行される処理
     */
    public function handle(): int
    {
        if (! $this->confirm('本当にすべてのメモを削除しますか？')) {
            $this->info('処理を中止しました。');
            return self::SUCCESS;
        }

        Memo::query()->delete();

        $this->info('すべてのメモを削除しました。');

        return self::SUCCESS;
    }
}
