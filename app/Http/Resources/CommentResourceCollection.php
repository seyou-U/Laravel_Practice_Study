<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // コメントは複数あることが想定されるため、コメント投稿をリソースコレクション1つで表現するのではなく1つ1つの集合体として実装する
        return $this->resource->map(function ($value) {
            return new CommentResource($value);
        })->all();
    }
}
