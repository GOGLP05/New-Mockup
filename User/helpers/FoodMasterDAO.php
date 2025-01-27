<?php
require_once 'DAO.php';
class FoodMaster
{
    public int $food_id;
    public string $food_name;
    public string $expiry_date;
    public int $category_id;
    public string $category_name;
    public string $standard_gram;
    public string $food_file_path;
    public ?string $latest_lot_no = null;
}

class FoodMasterDAO
{
    public function get_foods()
    {
        $dbh = DAO::get_db_connect();
        $sql = "SELECT * FROM food_master";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $data = [];
        while ($row = $stmt->fetchObject('FoodMaster')) {
            $data[] = $row;
        }
        return $data;
    }

    public function get_food_by_id($foodId)
    {
        error_log("food_id: " . $foodId); // food_idをログに出力
        $dbh = DAO::get_db_connect();
        $sql = "SELECT * FROM registrated_food WHERE food_id = :food_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':food_id', $foodId, PDO::PARAM_INT);
        $stmt->execute();
        $food = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$food) {
            error_log("Error: food_id " . $foodId . " not found.");
        }

        return $food;
    }


    public function get_foods_by_name($search) {
        $dbh = DAO::get_db_connect();
        $sql = "SELECT * FROM food_master WHERE food_name LIKE :search";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    public function update_food_amount_by_lot($foodId, $lotNo, $newAmount)
    {
        $dbh = DAO::get_db_connect();
        $dbh->beginTransaction();  // トランザクション開始

        try {
            $sql = "UPDATE registrated_food 
                SET standard_gram = :standard_gram 
                WHERE food_id = :food_id 
                AND lot_no = :lot_no";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':standard_gram', $newAmount, PDO::PARAM_INT);
            $stmt->bindValue(':food_id', $foodId, PDO::PARAM_INT);
            $stmt->bindValue(':lot_no', $lotNo, PDO::PARAM_STR);
            $stmt->execute();

            $dbh->commit();  // コミット
            return true;
        } catch (Exception $e) {
            $dbh->rollBack();  // ロールバック
            error_log("Error updating food amount by lot: " . $e->getMessage());
            return false;
        }
    }


    public function get_foods_by_category($category_id)
    {
        $dbh = DAO::get_db_connect();
        $sql = "SELECT * FROM food_master WHERE category_id = :category_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->execute();
        $data = [];
        while ($row = $stmt->fetchObject('FoodMaster')) {
            $data[] = $row;
        }
        return $data;
    }

    public function get_categories()
    {
        $dbh = DAO::get_db_connect();
        $sql = "SELECT DISTINCT category_id, category_name FROM food_master ORDER BY category_name";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }

    public function get_category_by_food_id($food_id)
    {
        $dbh = DAO::get_db_connect();
        $sql = "SELECT category_id FROM food_master WHERE food_id = :food_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':food_id', $food_id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    public function get_foods_by_id_and_member($foodId, $memberId)
    {
        $dbh = DAO::get_db_connect();
        $sql = "SELECT * 
            FROM registrated_food 
            WHERE food_id = :food_id 
              AND member_id = :member_id
            ORDER BY expire_date ASC";  // 有効期限順で並べる
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':food_id', $foodId, PDO::PARAM_INT);
        $stmt->bindValue(':member_id', $memberId, PDO::PARAM_INT);
        $stmt->execute();
        $foods = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$foods) {
            error_log("No records found for food_id: {$foodId}, member_id: {$memberId}");
        }

        return $foods;
    }
}
