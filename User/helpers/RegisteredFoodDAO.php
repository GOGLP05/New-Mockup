<?php
require_once 'DAO.php';

class RegisteredFood
{
    public int $food_id;
    public string $food_name;
    public int $member_id;
    public string $lot_no;
    public string $registration_date;
    public float $food_gram;
    public int $food_amount;
    public string $expire_date;
}

class RegisteredFoodDAO
{
    // 全ての食品データを取得する
    public function get_all_foods(): array
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM registrated_food";
        $stmt = $dbh->prepare($sql);

        if (!$stmt->execute()) {
            throw new Exception('Failed to execute the query.');
        }

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'RegisteredFood');
    }

    // 特定の食品データをIDで取得する
    public function get_food_by_id(int $food_id): ?RegisteredFood
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM registrated_food WHERE food_id = :food_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':food_id', $food_id, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            throw new Exception('Failed to execute the query.');
        }

        $food = $stmt->fetchObject('Food');
        return $food ?: null;
    }

    // 新しい食品を登録する
    public function create_food(string $food_name, int $member_id, string $lot_no, string $registration_date, float $food_gram, int $food_amount, string $expire_date): bool
    {
        try {
            $dbh = DAO::get_db_connect();

            $sql = "INSERT INTO registrated_food (food_name, member_id, lot_no, registration_date, food_gram, food_amount, expire_date) 
                    VALUES (:food_name, :member_id, :lot_no, :registration_date, :food_gram, :food_amount, :expire_date)";
            $stmt = $dbh->prepare($sql);

            $stmt->bindValue(':food_name', $food_name, PDO::PARAM_STR);
            $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
            $stmt->bindValue(':lot_no', $lot_no, PDO::PARAM_STR);
            $stmt->bindValue(':registration_date', $registration_date, PDO::PARAM_STR);
            $stmt->bindValue(':food_gram', $food_gram, PDO::PARAM_STR);
            $stmt->bindValue(':food_amount', $food_amount, PDO::PARAM_INT);
            $stmt->bindValue(':expire_date', $expire_date, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new Exception('データベースエラー');
        }
    }

    // 食品データを更新する
    public function update_food(int $food_id, array $updates): bool
    {
        try {
            $dbh = DAO::get_db_connect();

            $sql = "UPDATE registrated_food SET ";
            $set_parts = [];
            foreach ($updates as $column => $value) {
                $set_parts[] = "$column = :$column";
            }
            $sql .= implode(', ', $set_parts);
            $sql .= " WHERE food_id = :food_id";

            $stmt = $dbh->prepare($sql);

            foreach ($updates as $column => $value) {
                $stmt->bindValue(":$column", $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
            }
            $stmt->bindValue(':food_id', $food_id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new Exception('データベースエラー');
        }
    }

    // 食品データを削除する
    public function delete_food(int $food_id): bool
    {
        try {
            $dbh = DAO::get_db_connect();

            $sql = "DELETE FROM registrated_food WHERE food_id = :food_id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':food_id', $food_id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new Exception('データベースエラー');
        }
    }
}
?>
