<?php
require_once 'DAO.php';

class Category {
    public int $category_id;
    public string $category_name;
    public ?int $use_unit;
}

class CategoryDAO {
    private $pdo;

    public function __construct() {
        // データベース接続の初期化
        $this->pdo = DAO::get_db_connect();
    }

    // カテゴリ一覧を取得
    public function get_categories() {
        $dbh = DAO::get_db_connect(); 
        $sql = "SELECT * FROM category";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $data = []; 
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $category = new Category();
            $category->category_id = (int)$row['category_id'];
            $category->category_name = $row['category_name'];
            
            // NULLを0に変換して代入
            $category->use_unit = isset($row['use_unit']) ? (int)$row['use_unit'] : 0;  // NULLを0に変換
            
            $data[] = $category;
        } 
        return $data;
    }
    
    // 次のカテゴリIDを取得
    public function get_next_category_id(): int {
        $sql = "SELECT MAX(category_id) + 1 AS next_id FROM category";
        $stmt = $this->pdo->query($sql);
        $row = $stmt->fetch();
        return $row['next_id'] ?? 1; // データがない場合は1を返す
    }

    public function get_category_by_id($id) {
        $sql = "SELECT * FROM category WHERE category_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject('Category');
    }
    
    // カテゴリの更新
    public function update_category($category_id, $category_name) {
        $dbh = DAO::get_db_connect();
        $sql = "UPDATE category SET category_name = :category_name WHERE category_id = :category_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':category_name', $category_name, PDO::PARAM_STR);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    // 新しいカテゴリの追加
    public function insert_category($category_name) {
        $dbh = DAO::get_db_connect();
    
        // 次のカテゴリIDを取得
        $next_id = $this->get_next_category_id();
    
        $sql = "INSERT INTO category (category_id, category_name) VALUES (:category_id, :category_name)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':category_id', $next_id, PDO::PARAM_INT);
        $stmt->bindValue(':category_name', $category_name, PDO::PARAM_STR);
        $stmt->execute();
    }
            // カテゴリの削除
    public function delete_category($category_id) {
        $dbh = DAO::get_db_connect();
        $sql = "DELETE FROM category WHERE category_id = :category_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->execute();
    }

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

    public function get_category_id_by_food_id($food_id) {
        try {
            // DB接続を取得
            $dbh = DAO::get_db_connect();

            // SQL文の準備
            $sql = "SELECT category_id FROM category WHERE food_id = :food_id";
            $stmt = $dbh->prepare($sql);

            // パラメータをバインド
            $stmt->bindValue(':food_id', $food_id, PDO::PARAM_INT);

            // SQLを実行
            $stmt->execute();

            // 結果をフェッチ
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result['category_id'];
            } else {
                error_log("食品ID $food_id に対応するカテゴリIDが見つかりません");
                return null; // 見つからなかった場合はnullを返す
            }
        } catch (PDOException $e) {
            // 例外が発生した場合のログ出力
            error_log("データベースエラー: " . $e->getMessage());
            return null; // エラー時はnullを返す
        } catch (Exception $e) {
            // その他の例外
            error_log("予期しないエラー: " . $e->getMessage());
            return null; // エラー時はnullを返す
        }
    }
}
