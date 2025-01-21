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
        $sql = "INSERT INTO category (category_name) VALUES (:category_name)";
        $stmt = $dbh->prepare($sql);
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
}
