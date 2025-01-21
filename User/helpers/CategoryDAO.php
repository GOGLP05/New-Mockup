<?php

require_once 'DAO.php';

class Category
{
    public int $category_id;
    public string $category_name;
    public string $use_unit;
}

class CategoryDAO
{
    // カテゴリーIDに基づいてuse_unitを取得
    public function get_use_unit_by_category_id($categoryId)
    {
        // DB接続を取得
        $dbh = DAO::get_db_connect();

        // SQL文の準備
        $sql = "SELECT use_unit FROM category WHERE category_id = :category_id";

        // SQL文を実行するために準備
        $stmt = $dbh->prepare($sql);

        // パラメータをバインド
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);

        // SQLを実行
        $stmt->execute();

        // 結果をフェッチ
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // 結果があればuse_unitを返す。なければデフォルト値を0（個）を返す
        return $result ? $result['use_unit'] : '個';
    }
}
