<?php

namespace App;

interface NotifierInterface
{
    public function send(string $to, string $message): void;
}
