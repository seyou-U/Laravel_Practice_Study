<?php

namespace App\Interfaces;

interface NotifierInterface
{
    public function send(string $to, string $message): void;
}
