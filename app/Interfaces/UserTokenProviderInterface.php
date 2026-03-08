<?php

namespace App\Interfaces;

use stdClass;

interface UserTokenProviderInterface
{
    public function retrieveUserByToken(string $token): ?stdClass;
}
