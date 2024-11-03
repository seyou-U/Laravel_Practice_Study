<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'authors';

    // モデル内でのプライマリーキー明示
    // protected $primaryKey = 'author_id';

    // 自動的にタイムスタンプの記録する設定をオフにすることができる
    // protected $timestamps = false;

    // $fillableで編集などが可能なカラム。$guardedで編集などが不可能なカラムを選択する
    // しかし、DBが冗長になるにつれfillableは追加しないといけないことを考慮すると、fillableよりもguardedを指定する方が良い
    protected $fillable = [
        'name',
        'kana'
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    // Kanaカラムの値を半角カナに変換するアクセサ (データを取得する際に呼び出される処理)を定義
    public function getKanaAttribute(string $value): string
    {
        return mb_convert_kana($value, "k");
    }

    // Kanaカラムの値を半角カナに変換するミューテータ (データを登録する際に呼び出される処理) を定義
    public function setKanaAttribute(string $value)
    {
        $this->attributes['kana'] = mb_convert_kana($value, 'KV');
    }
}
