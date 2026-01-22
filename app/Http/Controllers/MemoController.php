<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemoRequest;
use App\Http\Resources\MemoResource;
use App\Models\Memo;
use Illuminate\Http\Request;

class MemoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $memos = Memo::where('user_id', $request->user()->id)
            ->orderByDesc('updated_at')
            ->paginate(10);

        return response()->json($memos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMemoRequest $request)
    {
        logger()->info('MemoController@store called', [
        'auth_user_id' => optional($request->user())->id,
        'validated' => $request->validated(),
        'all' => $request->all(),
    ]);
        $validated = $request->validated();
        $memo = Memo::create([
            ...$validated,
            'user_id' => $request->user()->id,
        ]);

        return response()->json($memo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Memo $memo)
    {
        // MemoResourceを使った記述
        // return new MemoResource($memo);

        // 他人のメモを見れないようにする
        abort_unless($memo->user_id === $request->user()->id, 403);

        return response()->json($memo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Memo $memo)
    {
        abort_unless($memo->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $memo->update($validated);

        return response()->json($memo);
        // MemoResourceを使った記述
        // return new MemoResource($memo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Memo $memo)
    {
        abort_unless($memo->user_id === $request->user()->id, 403);

        $memo->delete();

        return response()->noContent(); // 204
    }
}
