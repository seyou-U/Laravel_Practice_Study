<?php

namespace App\Listeners;

use App\Events\PublishProcessor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MessageSubscriber
{
    public function __invoke()
    {
        //
    }
    /**
     * Handle the event.
     */
    public function handle(PublishProcessor $event): void
    {
        var_dump($event->getInt());
    }
}
