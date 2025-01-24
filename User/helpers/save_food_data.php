<?php
require_once 'DAO.php';

header("Content-Type: application/json");

try {
    // JSON リクエストを取得
    $input = json_decode(file_get_contents("php://input"), true);

    // 必要なデータを取得
    $food_id = $input['food_id'];
    $food_name = $input['food_name'];
    $amount = $input['amount'] ?? null;
    $member_id = $input['member_id'] ?? null;
    $date = $input['date'] ?? null;
    $use_unit = $input['use_unit'] ?? null;
// 必要な値が揃っているか確認
// 必要な値が揃っているか確認
if (!$food_name) {
    throw new Exception("food_nameが不足しています。");
}
if (!$amount) {
    throw new Exception("amountが不足しています。");
}
if (!$date) {
    throw new Exception("dateが不足しています。");
}
if (!$food_id) {
    throw new Exception("food_idが不足しています。");
}
if (!$member_id) {
    throw new Exception("member_idが不足しています。");
}
if ($use_unit === null) {
    throw new Exception("use_unitが不足しています。");
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

    // expiry_daysを設定
    $expiry_days = (int)$result['expiry_date'];

    // 登録日と有効期限を計算
    $registration_date = new DateTime($date);
    $expire_date = $registration_date->modify("+{$expiry_days} days")->format('Y-m-d');

    // food_amount と standard_gram を計算
    if ($use_unit == "g" || $use_unit == "ml") {
        // gまたはmlの場合、food_amountはNULLでstandard_gramにcountをそのままセット
        $food_amount = null;
        $standard_gram = $amount;
    } else {
        // その他の単位の場合、food_amountに入力値を設定し、standard_gramは数量×標準グラム
        $food_amount = $amount;
        $standard_gram = $amount * (int)$result['standard_gram'];
    }

    // SQL文を作成
    $sql = "INSERT INTO registrated_food (food_id, member_id, lot_no, food_name, registration_date, food_amount, standard_gram, expire_date) 
            VALUES (:food_id, :member_id, DATEADD(HOUR, 9, GETDATE()), :food_name, :registration_date, :food_amount, :standard_gram, :expire_date)";

    // プレースホルダーに値をバインド
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':food_id', $food_id, PDO::PARAM_INT);
    $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
    $stmt->bindValue(':food_name', $food_name, PDO::PARAM_STR);
    $stmt->bindValue(':registration_date', $date, PDO::PARAM_STR);
    $stmt->bindValue(':food_amount', $food_amount, PDO::PARAM_INT);
    $stmt->bindValue(':standard_gram', $standard_gram, PDO::PARAM_INT);
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
