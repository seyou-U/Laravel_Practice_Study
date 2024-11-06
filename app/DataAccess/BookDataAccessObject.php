<?php

namespace App\DataAccess;

use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\DB;

// クエリビルダを用いるための専用クラス (booksテーブルのデータ操作を担うクラス)
class BookDataAccessObject
{
    protected $db;
    protected $table = 'books';

    /**
     * コンストラクタ
     */
    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }

    /**
     * クエリビルダやEloquentを用いることなく直接SQLを記述しデータを取得する
     */
    public function dataExtractionUsingSQL(): Array
    {
        $sql = $this->commonlyUsedSql();

        // 第一引数にSQLを指定して、第二引数にプリペアドステートメント(変更する箇所だけを変数のようにした命令文を作る仕組み)を指定する
        $result = DB::select($sql, ['1000', '2011-01-01']);

        return $result;
    }

    /**
     * PDOを記述し、データを取得する
     */
    public function dataExtractionUsingPdo(): Array
    {
        $sql = $this->commonlyUsedSql();
        $pdo = DB::connection()->getPdo();
        // prepareメソッドは変動値を含むSQLを実行させるために使用するメソッド
        $statement = $pdo->prepare($sql);
        // executeメソッドはプリペアドステートメントを実行する前に使われる
        $statement->execute(['1000', '2011-01-01']);
        $results = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $results;
    }

    /**
     * 素のSQLおよびPDOを用いた実装で呼び出される共通のSQL
     */
    public function commonlyUsedSql(): String
    {
        return 'SELECT bookdetails.isbn, books.name '
        . 'FROM books '
        . 'LEFT JOIN bookdetails ON books.id = bookdetails.book_id '
        . 'WHERE bookdetails.price >= ? AND bookdetails.published_date >= ? '
        . 'ORDER BY bookdetails.published_date DESC';
    }
}
