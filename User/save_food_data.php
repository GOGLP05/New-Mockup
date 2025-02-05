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

    // food_masterテーブルからexpiry_dateとstandard_gramを取得
    $query = "SELECT expiry_date, standard_gram FROM food_master WHERE food_id = :food_id";
    $stmt = $dbh->prepare($query);
    $stmt->bindValue(':food_id', $food_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        throw new Exception("食品IDが無効です。");
    }

    $expiry_days = (int)$result['expiry_date'];
    $standard_gram = (int)$result['standard_gram'];

    // expire_dateを計算 (登録日 + expiry_days 日)
    $registration_date = new DateTime($date);
    $expire_date = $registration_date->modify("+{$expiry_days} days")->format('Y-m-d');

    // SQL作成
    $sql = "INSERT INTO registrated_food (food_id, member_id, lot_no, food_name, registration_date, food_amount, standard_gram, expire_date) 
            VALUES (:food_id, :member_id, DATEADD(HOUR, 9, CURRENT_TIMESTAMP), :food_name, :registration_date, :food_amount, :standard_gram, :expire_date)";

    $stmt = $dbh->prepare($sql);

    // プレースホルダーに値をバインド
    $stmt->bindValue(':food_id', $food_id, PDO::PARAM_INT);
    $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
    $stmt->bindValue(':food_name', $food_name, PDO::PARAM_STR);
    $stmt->bindValue(':registration_date', $date, PDO::PARAM_STR);
    $stmt->bindValue(':food_amount', $amount, PDO::PARAM_INT);
    $stmt->bindValue(':standard_gram', $standard_gram, PDO::PARAM_INT); // standard_gramを設定
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
