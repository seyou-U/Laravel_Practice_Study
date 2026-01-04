<?php

namespace App\Http\Controllers;

use App\Http\Resources\MemoResource;
use App\Models\Memo;
use Illuminate\Http\Request;

class MemoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $memos = Memo::all();
        return response()->json($memos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $memo = Memo::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return response()->json($memo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Memo $memo)
    {
        // MemoResourceを使った記述
        // return new MemoResource($memo);

        // Eloquentを使った記述
        // whereは条件で絞り込むのに対し、findは主キーでの検索
        return Memo::findOrFail($memo->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $memo = Memo::findOrFail($id);
        $memo->update($validated);

        return response()->json($memo);
        // MemoResourceを使った記述
        // return new MemoResource($memo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $memo = Memo::findOrFail($id);
        $memo->delete();

        return response()->json(null. 204);
    }
}
