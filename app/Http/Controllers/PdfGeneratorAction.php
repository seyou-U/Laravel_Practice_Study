<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\PdfGenerator;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class PdfGeneratorAction extends Controller
{
    private $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function __invoke(): void
    {
        $generator = new PdfGenerator(storage_path('pdf/sample.pdf'));

        // キューの分散 (複数ある場合)
        // dispatchヘルパ関数でどのQueueの処理を行うか指定する
        // 従来はdefaultだが、ここではpdf.generatorとして指定している
        dispatch($generator)->onQueue('pdf.generator');

        // コンストラクタインジェクションを利用して
        // Illuminate\Contracts\Bus\Dispatcherインターフェイスの
        // dispatchメソッドで実行指示。Busファサードを用いた記述もできる
        $this->dispatcher->dispatch($generator);

        // Illuminate\Contracts\Bus\DispatcherJobsトレイトで経由するでdispatchを利用可能
        // $this->dispatcher($generator);
        // dispatchヘルパ関数で実行
        dispatch($generator);
    }
}
