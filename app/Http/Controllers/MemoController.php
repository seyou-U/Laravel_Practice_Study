<?php

namespace App\Http\Controllers;

use App\Events\MemoCreated;
use App\Events\MemoUpdated;
use App\Http\Requests\StoreMemoRequest;
use App\Jobs\ExportMemosPdfJob;
use App\Models\AsyncJob;
use App\Models\Memo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class MemoController extends Controller
{
    /**
     * 10分間キャッシュを利用してメモの一覧を取得する
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $page = $request->query('page', 1);
        $key = "memos:index:user:{$userId}:page:{$page}";

        $memos = Cache::tags(["memos:user:{$userId}"])
            ->remember($key, now()->addMinutes(10), function() use ($userId, $page) {
                return Memo::where('user_id', $userId)
                    ->orderByDesc('updated_at')
                    ->paginate(10, ['*'], 'page', $page);
        });

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

        event(new MemoCreated($memo));

        return response()->json($memo, 201);
    }

    /**
     * 5分間キャッシュを利用してメモの詳細を取得する
     */
    public function show(Request $request, Memo $memo)
    {
        // MemoResourceを使った記述
        // return new MemoResource($memo);

        $userId = $request->user()->id;
        // 他人のメモを見れないようにする
        abort_unless($memo->user_id === $userId, 403);

        $key = "memos:show:user:{$userId}:memo:{$memo->id}";

        // fresh()は、最新のモデルの状態を返却するメソッド
        $memo = Cache::remember($key, now()->addMinutes(5), fn() => $memo->fresh());

        return response()->json($memo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Memo $memo)
    {
        abort_unless($memo->user_id === $request->user()->id, 403);

        $before = [
            'title' => $memo->title,
            'content' => $memo->content,
        ];

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $memo->update($validated);

        $after = [
            'title' => $memo->title,
            'content' => $memo->content,
        ];

        event(new MemoUpdated(
            memo: $memo,
            user: $request->user(),
            before: $before,
            after: $after,
        ));

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

    /**
     * Remove the specified resource from storage.
     */
    public function export(Request $request)
    {
        $userId = $request->user()->id;

        $asyncJob = AsyncJob::create([
            'id' => (string) Str::uuid(),
            'user_id' => $userId,
            'type' => 'memos_export',
            'status' => 'queued',
        ]);

        ExportMemosPdfJob::dispatch($asyncJob, $userId);

        return response()->json([
            'jobId' => $asyncJob->id,
            'status' => $asyncJob->status,
        ], 202);
    }
}
