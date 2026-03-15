<?php

namespace App\Console\Commands;

use App\Models\Memo;
use Illuminate\Console\Command;

class CountUserMemos extends Command
{
    /**
     * コマンド名
     *
     * @var string
     */
    protected $signature = 'memo:count-user {userId}';

    /**
     * コマンドの説明
     *
     * @var string
     */
    protected $description = '指定ユーザーのメモの登録件数を表示する';

    /**
     * 実行される処理
     */
    public function handle(): int
    {
        $userId = $this->argument('userId');

        $count = Memo::where('user_id', $userId)->count();

        $this->info("ユーザー{$userId}のメモの件数は{$count}件です");

        return self::SUCCESS;
    }
}
