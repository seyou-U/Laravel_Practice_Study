<?php

namespace App\Jobs;

use App\Models\AsyncJob;
use App\Models\Memo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ExportMemosPdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public AsyncJob $asyncJob,
        public int $userId
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $job = $this->asyncJob->refresh();
        $job->update(['status' => 'running']);

        $memos = Memo::where('user_id', $this->userId)
            ->orderByDesc('updated_at')
            ->get();

        $content = $memos
            ->map(fn ($m) => "{$m->title}\n{$m->content}\n---\n")
            ->join("\n");

        $path = "exports/memos_{$this->userId}_{$job->id}.txt";
        Storage::disk('public')->put($path, $content);

        $job->update([
            'status' => 'done',
            'result_url' => Storage::disk('public')->url($path),
        ]);
    }

    public function failed(\Throwable $e): void
    {
        AsyncJob::whereKey($this->asyncJob->getKey())->update([
            'status' => 'failed',
            'error' => $e->getMessage(),
        ]);
    }
}
