<?php

namespace App\Services;

use App\NotifierInterface;

class UserService
{
    protected $notifier;

    /**
     * コンストラクタ
     * コンストラクタインジェクション(コンストラクタの引数でインスタンスを注入する)の実装
     * コンストラクトのタイプヒンティングにインターフェイスや抽象クラスを指定する場合は、あらかじめバインドする必要がある
     */
    public function __construct(NotifierInterface $notifier)
    {
        $this->notifier = $notifier;
    }

    /**
     * 利用者に対する通知操作を受け持つクラス
     * NotifierInterfaceクラスに依存している / 何らかの手段で送るといった抽象的な役割をインターフェイスで持たせる
     * 引数はNotifierInterfaceを実装したクラスであればどのクラスでも可能
     */
    public function sendNotification(string $to, string $message): void
    {
        $this->notifier->send($to, $message);
    }
}
