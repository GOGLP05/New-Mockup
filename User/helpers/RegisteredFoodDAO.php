<?php
require_once 'DAO.php';

class RegisteredFood
{
    public int $food_id;
    public string $food_name;
    public int $member_id;
    public datetime $lot_no;
    public string $registration_date;
    public float $standard_gram;
    public int $food_amount;
    public string $expire_date;
}

class RegisteredFoodDAO
{
    // 全ての食品データを取得する
    public function get_all_foods_by_member(int $member_id): array
{
    $dbh = DAO::get_db_connect();

    $sql = "
        SELECT t1.food_name, 
               MAX(t1.registration_date) AS registration_date, 
               MAX(t1.expire_date) AS expire_date, 
               SUM(t1.food_amount) AS total_amount,
               SUM(t1.standard_gram) AS total_gram,
               fm.category_id
        FROM registrated_food t1
        JOIN food_master fm ON t1.food_name = fm.food_name
        WHERE t1.member_id = :member_id
        GROUP BY t1.food_name, fm.category_id
        ORDER BY MAX(t1.registration_date) DESC
    ";

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);

    if (!$stmt->execute()) {
        throw new Exception('Failed to execute the query.');
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    public function create_food(string $food_name, int $member_id, string $lot_no, string $registration_date, float $standard_gram, int $food_amount, string $expire_date): bool
    {
        try {
            $dbh = DAO::get_db_connect();

            $sql = "INSERT INTO registrated_food (food_name, member_id, lot_no, registration_date, standard_gram, food_amount, expire_date) 
                    VALUES (:food_name, :member_id, :lot_no, :registration_date, :standard_gram, :food_amount, :expire_date)";
            $stmt = $dbh->prepare($sql);

            $stmt->bindValue(':food_name', $food_name, PDO::PARAM_STR);
            $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
            $stmt->bindValue(':lot_no', $lot_no, PDO::PARAM_STR);
            $stmt->bindValue(':registration_date', $registration_date, PDO::PARAM_STR);
            $stmt->bindValue(':standard_gram', $standard_gram, PDO::PARAM_STR);
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
    public function get_registered_foods_with_images_by_member(int $member_id, $page = 1, $perPage = 50): array
{
    $offset = ($page - 1) * $perPage;

    $sql = "
        SELECT DISTINCT 
    fm.food_name, 
    fm.food_file_path, 
    fm.category_id, -- category_idを追加
    MAX(rf.lot_no) AS latest_lot_no
FROM 
    food_master fm
INNER JOIN 
    registrated_food rf 
    ON fm.food_name = rf.food_name
WHERE 
    rf.member_id = :member_id
GROUP BY 
    fm.food_name, 
    fm.food_file_path, 
    fm.category_id -- GROUP BYにcategory_idを追加
ORDER BY 
    latest_lot_no DESC
OFFSET 
    :offset ROWS FETCH NEXT :limit ROWS ONLY;

    ";

    $dbh = DAO::get_db_connect();
    $stmt = $dbh->prepare($sql);

    $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

    $stmt->execute();

    $data = [];
    while ($row = $stmt->fetchObject('FoodMaster')) {
        $data[] = $row;
    }

    return $data;
}




    // 特定の食品名のデータを取得する
    public function get_foods_by_name_and_member(string $food_name, int $member_id): array
{
    $dbh = DAO::get_db_connect();

    $sql = "
    SELECT r.food_name, 
           r.lot_no,
           r.registration_date, 
           r.expire_date, 
           SUM(r.food_amount) AS total_amount,
           f.category_id
    FROM registrated_food r
    JOIN food_master f ON r.food_name = f.food_name
    WHERE r.food_name = :food_name AND r.member_id = :member_id
    GROUP BY r.food_name, r.lot_no, r.registration_date, r.expire_date, f.category_id
    ORDER BY r.registration_date DESC
    ";

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':food_name', $food_name, PDO::PARAM_STR);
    $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);

    if (!$stmt->execute()) {
        throw new Exception('Failed to execute the query.');
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



    public function get_food_detail_by_name_and_lotno(string $food_name, string $lotno, int $member_id)
    {
        $dbh = DAO::get_db_connect();

        $sql = "
    SELECT * 
    FROM registrated_food
    WHERE food_name = :food_name 
      AND lot_no = :lotno 
      AND member_id = :member_id
    ";

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':food_name', $food_name, PDO::PARAM_STR);
        $stmt->bindValue(':lotno', $lotno, PDO::PARAM_STR); // DATETIME型でも文字列としてバインド
        $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            throw new Exception('Failed to execute the query.');
        }

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function get_expired_foods_by_member(int $member_id): array
{
    $dbh = DAO::get_db_connect();

    // 現在の日付を取得
    $today = date('Y-m-d');

    $sql = "
        SELECT t1.food_name, 
               MAX(t1.registration_date) AS registration_date, 
               MAX(t1.expire_date) AS expire_date, 
               SUM(t1.food_amount) AS total_amount,
               fm.category_id
        FROM registrated_food t1
        INNER JOIN food_master fm ON t1.food_name = fm.food_name  -- food_masterテーブルと結合
        WHERE t1.member_id = :member_id
        AND t1.expire_date < :today  -- expire_dateが今日より前のデータのみ取得
        GROUP BY t1.food_name, fm.category_id  -- food_nameとcategory_idでグループ化
        ORDER BY MAX(t1.registration_date) DESC
    ";

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
    $stmt->bindValue(':today', $today, PDO::PARAM_STR);  // 今日の日付をバインド

    if (!$stmt->execute()) {
        throw new Exception('Failed to execute the query.');
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function get_expiring_soon_foods_by_member(int $member_id): array
{
    $dbh = DAO::get_db_connect();

    // 今日の日付を取得
    $today = date('Y-m-d');
    // 今日から7日後の日付を計算
    $sevenDaysLater = date('Y-m-d', strtotime('+7 days'));

    $sql = "
    SELECT t1.food_name, 
           MAX(t1.registration_date) AS registration_date, 
           MAX(t1.expire_date) AS expire_date, 
           SUM(t1.food_amount) AS total_amount,
           fm.category_id
    FROM registrated_food t1
    LEFT JOIN food_master fm ON t1.food_name = fm.food_name
    WHERE t1.member_id = :member_id
    AND t1.expire_date BETWEEN :today AND :sevenDaysLater
    GROUP BY t1.food_name, fm.category_id
    ORDER BY MAX(t1.registration_date) DESC
    ";

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
    $stmt->bindValue(':today', $today, PDO::PARAM_STR);
    $stmt->bindValue(':sevenDaysLater', $sevenDaysLater, PDO::PARAM_STR);

    if (!$stmt->execute()) {
        throw new Exception('Failed to execute the query.');
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function subtract_food_amount($food_id, $amount)
    {
        $dbh = DAO::get_db_connect();
        $sql = "
            UPDATE registrated_food
            SET food_amount = food_amount - :amount
            WHERE food_id = :food_id AND food_amount >= :amount
        ";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':amount', $amount, PDO::PARAM_INT);
        $stmt->bindValue(':food_id', $food_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
