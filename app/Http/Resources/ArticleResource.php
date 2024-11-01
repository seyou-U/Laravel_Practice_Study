<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

// メインリソースのブログ記事を扱う
class ArticleResource extends JsonResource
{
    public static $wrap = '';

    /**
     * 渡された配列を構成する各リソースクラスに渡す
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        // それぞれのresourceインスタンスを生成する → 継承しているJsonResourceクラスのコンストラクタで$this->resourceを生成している
        return [
            'id' => $this->resource['id'],
            'title' => $this->resource['title'],
            '_embedded' => [
                'comments' => new CommentResourceCollection(
                    new Collection($this->resource['comments'])
                ),
                'user' => new UserResource(
                    [
                        'user_id' => $this->resource['user_id'],
                        'user_name' => $this->resource['user_name'],
                    ]
                ),
            ],
            '_links' => [
                'self' => [
                    'href' => sprintf(
                        'https://example.com/articles/%s',
                        $this->resource['id']
                    )
                ]
            ],
        ];
    }
}
