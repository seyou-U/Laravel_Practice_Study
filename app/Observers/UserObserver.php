<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    /**
     * ユーザーが作成された直後に呼ばれる
     */
    public function created(User $user): void
    {
        Log::info('ユーザーが作成されました', [
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
        ]);
    }
}
