<?php

namespace App\Http\Controllers;

use App\Models\AsyncJob;
use Illuminate\Http\Request;

class AsyncJobController extends Controller
{
    public function show(Request $request, AsyncJob $asyncJob)
    {
        abort_unless($asyncJob->user_id === $request->user()->id, 403);

        return response()->json([
            'id' => $asyncJob->id,
            'type' => $asyncJob->type,
            'status' => $asyncJob->status,
            'result_url' => $asyncJob->result_url,
            'error' => $asyncJob->error,
            'updatedAt' => $asyncJob->updated_at
        ]);
    }
}
