<?php
// update_food_inventory.php

// リクエストデータを受け取る
$data = json_decode(file_get_contents('php://input'), true);

// 必要なデータが存在するかチェック
if (isset($data['recipeId']) && isset($data['servings'])) {
    $recipeId = $data['recipeId'];
    $servings = $data['servings'];

    // 食品庫の更新処理
    try {
        // ここで食品庫の更新処理を行います（DAOの呼び出しなど）
        // 例: 食材の在庫を減らすなどの処理

        // 成功した場合
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        // エラーハンドリング
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => '必要なデータが不足しています']);
}
