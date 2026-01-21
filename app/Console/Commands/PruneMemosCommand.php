<?php

namespace App\Console\Commands;

use App\Models\Memo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PruneMemosCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:old-memos-prune';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '古いメモを削除する';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try{
            $deleted = Memo::where('created_at', '<', now()->subDays(10))
                ->delete();
            Log::info("10日よりも古いメモを{$deleted}削除しました");
            return self::SUCCESS;
        } catch (\Throwable $e) {
            Log::error('[batch:old-memos-prune] failed', [
                'error' => $e->getMessage(),
            ]);
            $this->error('failed: '.$e->getMessage());
            return self::FAILURE;
        }
    }
}
