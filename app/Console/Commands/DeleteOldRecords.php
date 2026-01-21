<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeleteOldRecords extends Command
{
    /**
     * コマンド名
     *
     * @var string
     */
    protected $signature = 'records:delete-old';

    /**
     * コマンドの説明
     *
     * @var string
     */
    protected $description = '古いレコードを削除する';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 本来はDB削除などを記述する
        Log::info('古いレコードを削除しました');
        $this->info('古いレコードを削除しました');
    }
}
