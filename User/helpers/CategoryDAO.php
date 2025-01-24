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
        try {
            // DB接続を取得
            $dbh = DAO::get_db_connect();
            error_log("DB接続成功");

            // SQL文の準備
            $sql = "SELECT use_unit FROM category WHERE category_id = :category_id";
            $stmt = $dbh->prepare($sql);

            // パラメータをバインド
            $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);

            // SQLを実行
            $stmt->execute();
            error_log("SQL実行成功: category_id = $categoryId");

            // 結果をフェッチ
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                error_log("取得した結果: " . print_r($result, true));
                $useUnit = $result['use_unit'];

                if ($useUnit == 1) {
                    return "個";
                } elseif ($useUnit == 0) {
                    return "g";
                } elseif ($useUnit == 3) {
                    return "ml";
                } else {
                    error_log("予期しないuse_unitの値: $useUnit");
                    return 'エラーです';
                }
            } else {
                error_log("カテゴリID $categoryId に対応する結果が見つかりません");
                return 'エラーです';
            }
        } catch (PDOException $e) {
            // 例外が発生した場合のログ出力
            error_log("データベースエラー: " . $e->getMessage());
            return 'エラーです';
        } catch (Exception $e) {
            // その他の例外
            error_log("予期しないエラー: " . $e->getMessage());
            return 'エラーです';
        }
    }
}
