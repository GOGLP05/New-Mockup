<?php
require_once 'DAO.php';

header("Content-Type: application/json");

try {
    // JSON リクエストを取得
    $input = json_decode(file_get_contents("php://input"), true);

    // 必要なデータを取得
    $food_id = $input['food_id'] ?? null;
    $food_name = $input['food_name'] ?? null;
    $amount = $input['amount'] ?? null;
    $member_id = $input['member_id'] ?? null;
    $date = $input['date'] ?? null;

    // 必要な値が揃っているか確認
    if (!$food_name || !$amount || !$date || !$food_id || !$member_id) {
        throw new Exception("入力データが不足しています。");
    }

    // DB接続
    $dbh = DAO::get_db_connect();

    // food_masterテーブルからexpiry_dateを取得
    $expiry_query = "SELECT expiry_date FROM food_master WHERE food_id = :food_id";
    $expiry_stmt = $dbh->prepare($expiry_query);
    $expiry_stmt->bindValue(':food_id', $food_id, PDO::PARAM_INT);
    $expiry_stmt->execute();
    $expiry_result = $expiry_stmt->fetch(PDO::FETCH_ASSOC);

    if (!$expiry_result) {
        throw new Exception("食品IDが無効です。");
    }

    $expiry_days = (int)$expiry_result['expiry_date'];

    // expire_dateを計算 (登録日 + expiry_days 日)
    $registration_date = new DateTime($date);
    $expire_date = $registration_date->modify("+{$expiry_days} days")->format('Y-m-d');

    // SQL作成
    $sql = "INSERT INTO registrated_food (food_id, member_id, lot_no, food_name, registration_date, food_amount, food_gram, expire_date) 
            VALUES (:food_id, :member_id, DATEADD(HOUR, 9, CURRENT_TIMESTAMP), :food_name, :registration_date, :food_amount, :food_gram, :expire_date)";

    $stmt = $dbh->prepare($sql);

    // プレースホルダーに値をバインド
    $stmt->bindValue(':food_id', $food_id, PDO::PARAM_INT);
    $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
    $stmt->bindValue(':food_name', $food_name, PDO::PARAM_STR);
    $stmt->bindValue(':registration_date', $date, PDO::PARAM_STR);
    $stmt->bindValue(':food_amount', $amount, PDO::PARAM_INT);
    $stmt->bindValue(':food_gram', 0, PDO::PARAM_INT);
    $stmt->bindValue(':expire_date', $expire_date, PDO::PARAM_STR);

    // 実行
    $stmt->execute();

    // レスポンス
    echo json_encode(["status" => "success", "message" => "データが保存されました。"]);
} catch (Exception $e) {
    // エラーレスポンス
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
