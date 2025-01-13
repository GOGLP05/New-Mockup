<?php
require_once 'DAO.php';

header("Content-Type: application/json");

try {
    // JSON リクエストを取得
    $input = json_decode(file_get_contents("php://input"), true);

    // 必要なデータを取得
    $food_name = $input['food_name'] ?? null;
    $amount = $input['amount'] ?? null;
    $date = $input['date'] ?? null;

    // 必要な値が揃っているか確認
    if (!$food_name || !$amount || !$date) {
        throw new Exception("入力データが不足しています。");
    }

    // expire_dateを計算 (登録日 + 7日)
    $registration_date = new DateTime($date);
    $expire_date = $registration_date->modify('+7 days')->format('Y-m-d');

    // DB接続
    $dbh = DAO::get_db_connect();

    // SQL作成
    $sql = "INSERT INTO registrated_food (food_id, member_id, lot_no, food_name, registration_date, food_amount, food_gram, expire_date) 
            VALUES (:food_id, :member_id, :lot_no, :food_name, :registration_date, :food_amount, :food_gram, :expire_date)";

    $stmt = $dbh->prepare($sql);

    // プレースホルダーに値をバインド
    $stmt->bindValue(':food_id', '400001', PDO::PARAM_STR); // 一意のfood_idを生成
    $stmt->bindValue(':member_id', '100001', PDO::PARAM_STR); // 例: 固定値やセッションから取得
    $stmt->bindValue(':lot_no', rand(1, 1000), PDO::PARAM_INT); // 例: ランダムなlot_no
    $stmt->bindValue(':food_name', $food_name, PDO::PARAM_STR);
    $stmt->bindValue(':registration_date', $date, PDO::PARAM_STR);
    $stmt->bindValue(':food_amount', $amount, PDO::PARAM_INT);
    $stmt->bindValue(':food_gram', 0, PDO::PARAM_INT); // 例: デフォルト値
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
