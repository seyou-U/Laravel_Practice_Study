<?php

namespace App\Console\Commands;

use App\Models\Memo;
use Illuminate\Console\Command;

class CountMemos extends Command
{
    /**
     * コマンド名
     *
     * @var string
     */
    protected $signature = 'memo:count';

    /**
     * コマンドの説明
     *
     * @var string
     */
    protected $description = 'メモの登録件数を表示する';

    /**
     * 実行される処理
     */
    public function handle(): int
    {
        $count = Memo::count();

        $this->info("現在のメモの件数は{$count}件です");

        return self::SUCCESS;
    }
}
