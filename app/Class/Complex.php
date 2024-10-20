<?php

namespace App\Class;

use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;

class Complex
{
    protected $logger;
    protected $characterLogged;

    public function __construct(LoggerInterface $logger, $characterLogged)
    {
        $this->logger = $logger;
        $this->characterLogged = $characterLogged;
    }

    // 初期化を行う
    public function setup()
    {
        // 初期化処理を記述(ここでは動作確認用としてLogを残す処理を記述)
        Log::info($this->characterLogged);
    }
}
