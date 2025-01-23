<?php
require_once 'DAO.php';

class FoodMaster {
    public int $food_id;
    public string $food_name;
    public string $expiry_date;
    public string $category_id;
    public string $category_name;
    public string $standard_gram;
    public string $food_file_path;
}

class FoodMasterDAO {

    private $pdo;

    public function __construct() {
        // データベース接続を初期化
        $this->pdo = DAO::get_db_connect();
    }

    public function get_foods() {
        $sql = "SELECT * FROM food_master";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $data = [];
        while ($row = $stmt->fetchObject('FoodMaster')) {
            $data[] = $row;
        }
        return $data;
    }

    public function get_name_and_path() {
        $sql = "SELECT food_name, food_file_path FROM food_master";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $data = [];
        while ($row = $stmt->fetchObject('FoodMaster')) {
            $data[] = $row;
        }
        return $data;
    }

    public function get_use_unit() {
        $sql = "SELECT food_name, food_file_path FROM food_master";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $data = [];
        while ($row = $stmt->fetchObject('FoodMaster')) {
            $data[] = $row;
        }
        return $data;
    }

    public function get_name_and_path_paginated($page = 1, $perPage = 50) {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT food_name, food_file_path FROM food_master 
                ORDER BY food_name 
                OFFSET :offset ROWS FETCH NEXT :limit ROWS ONLY";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $data = [];
        while ($row = $stmt->fetchObject('FoodMaster')) {
            $data[] = $row;
        }
        return $data;
    }

    // 食品IDで食品を削除
    public function delete($food_id) {
        // SQLクエリで食品を削除
        $stmt = $this->pdo->prepare("DELETE FROM food_master WHERE food_id = :food_id");
        $stmt->bindParam(':food_id', $food_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // 次の食品IDを取得
    public function get_next_food_id() {
        $sql = "SELECT MAX(food_id) AS max_food_id FROM food_master";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['max_food_id'] + 1;  // 最大値に1を加算して次のIDを返す
    }

    // 特定の食品IDを取得
    public function get_food_by_id($food_id) {
        $sql = "SELECT * FROM food_master WHERE food_id = :food_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':food_id', $food_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject('FoodMaster');
    }

    // 新規登録メソッド
public function insert_food($food_name, $expiry_date, $food_file_path, $category_id, $standard_gram, $category_name) {
    // food_idを自動で設定する場合
    $food_id = $this->get_next_food_id(); // 次のIDを取得

    // 食品をデータベースに挿入
    $query = "INSERT INTO food_master (food_id, food_name, expiry_date, food_file_path, category_id, standard_gram, category_name) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $this->pdo->prepare($query);
    $stmt->bindValue(1, $food_id, PDO::PARAM_INT);  // food_idを挿入
    $stmt->bindValue(2, $food_name, PDO::PARAM_STR);
    $stmt->bindValue(3, $expiry_date, PDO::PARAM_STR);
    $stmt->bindValue(4, $food_file_path, PDO::PARAM_STR);
    $stmt->bindValue(5, $category_id, PDO::PARAM_STR);
    $stmt->bindValue(6, $standard_gram, PDO::PARAM_STR);
    $stmt->bindValue(7, $category_name, PDO::PARAM_STR);
    
    return $stmt->execute();
}

    // 更新メソッド
    public function update_food($food_id, $food_name, $expiry_date, $food_file_path, $category_id, $standard_gram, $category_name) {
        $query = "UPDATE food_master 
                  SET food_name = ?, expiry_date = ?, food_file_path = ?, category_id = ?, standard_gram = ?, category_name = ? 
                  WHERE food_id = ?";
        // データベース操作
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(1, $food_name, PDO::PARAM_STR);
        $stmt->bindValue(2, $expiry_date, PDO::PARAM_STR);
        $stmt->bindValue(3, $food_file_path, PDO::PARAM_STR);
        $stmt->bindValue(4, $category_id, PDO::PARAM_STR);
        $stmt->bindValue(5, $standard_gram, PDO::PARAM_STR);
        $stmt->bindValue(6, $category_name, PDO::PARAM_STR);
        $stmt->bindValue(7, $food_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function get_all_categories() {
        try {
            // 'categories' テーブルの確認
            $sql = "SELECT category_name, category_id FROM category"; 
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'SQLエラー: ' . $e->getMessage();
            exit;
        }
    }

    // 食品名で食品が存在するかを確認するメソッド
    public function check_if_food_exists($food_name) {
        $sql = "SELECT COUNT(*) FROM food_master WHERE food_name = :food_name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':food_name', $food_name, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0; // 存在すればtrueを返す
    }

    // その他のメソッド（例: get_food_by_name）も必要に応じて実装
    public function get_food_by_name($food_name) {
        $sql = "SELECT * FROM food_master WHERE food_name = :food_name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':food_name', $food_name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject('FoodMaster');
    }


}
?>
