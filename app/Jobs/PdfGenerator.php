<?php

namespace App\Jobs;

use Carbon\Traits\Serialization;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Knp\Snappy\Pdf;

// Jobクラス
class PdfGenerator implements ShouldQueue
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
    public function handle(Pdf $pdf): void
    {
        // html形式でPDF出力を指定する
        $pdf->generateFromHtml(
            '<h1>Laravel</h1><p>Sample PDF OutPut.</p>', $this->path
        );
    }
}
