<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Memo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'content',
    ];

    // JSONに含めたい属性の追加
    protected $appends = ['content_excerpt'];

    protected $casts = [
        'content' => 'encrypted',
    ];

    /**
     * Title取得、保存時に自動で加工する
     *
     * return Attribute
     */
    protected function title(): Attribute
    {
        return Attribute::make(
            // 取得時(Accessor) 取得時タイトルの前に[メモ]をつける
            get: fn(?string $value) => $value === null ? null : "【メモ】{$value}",

            // 保存時(Mutator) 保存時前後の空白を削除する
            set: fn(?string $value) => $value === null ? null : trim($value),
        );
    }

    /**
     * 本文から60文字を抜粋を作成
     *
     * return Attribute
     */
    protected function contentExcerpt(): Attribute
    {
        // $attributeはDBから取得した生データ配列
        return Attribute::make(
            get: fn($value, array $attribute) =>
                Str::limit($attribute['content'] ?? '', 60, '...')
        );
    }
}
