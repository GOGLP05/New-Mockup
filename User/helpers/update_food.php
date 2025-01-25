<?php
require_once 'FoodMasterDAO.php';
require_once 'RecipeMasterDAO.php';
require_once 'RegisteredFoodDAO.php';
header("Content-Type: application/json");

// リクエストデータの取得
$data = json_decode(file_get_contents("php://input"), true);
$recipeId = $data['recipe_id'];
$servingCount = $data['serving_count'];
$memberId = $data['member_id'];

// 必要なフィールドが揃っているか確認
$missingFields = [];
if (empty($data['recipe_id'])) $missingFields[] = 'recipe_id';
if (empty($data['serving_count'])) $missingFields[] = 'serving_count';
if (empty($data['member_id'])) $missingFields[] = 'member_id';

if (!empty($missingFields)) {
    echo json_encode([
        'success' => false,
        'message' => '必要なデータが不足しています。',
        'missing_fields' => $missingFields
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// DAOのインスタンスを作成
$foodMasterDAO = new FoodMasterDAO();
$recipeMasterDAO = new Recipe_MasterDAO();
$registeredFoodDAO = new RegisteredFoodDAO();

// レシピに必要な食材を取得
$ingredients = $recipeMasterDAO->get_ingredients_by_recipe_id($recipeId);

// 必要な食材データの確認
if (empty($ingredients)) {
    echo json_encode([
        'success' => false,
        'message' => 'レシピに必要な食材データが存在しません。',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// 食材ごとに在庫を確認し、消費する
foreach ($ingredients as $ingredient) {
    $foodId = $ingredient['food_id'];
    $calculationUse = $ingredient['calculation_use'] * $servingCount; // 必要量を計算

    // 各食材の在庫を取得
    $foods = $foodMasterDAO->get_foods_by_id_and_member($foodId, $memberId);

    $totalAmount = 0;
    foreach ($foods as $food) {
        $totalAmount += $food['standard_gram']; // 各ロットの在庫量を合算
    }

    // 在庫が不足している場合、エラーメッセージを返す
    if ($totalAmount < $calculationUse) {
        echo json_encode([
            'success' => false,
            'message' => '在庫が不足しています。',
            'details' => [
                'food_id' => $foodId,
                'required_amount' => $calculationUse,
                'available_amount' => $totalAmount
            ]
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}

// 在庫を消費
foreach ($ingredients as $ingredient) {
    $foodId = $ingredient['food_id'];
    $calculationUse = $ingredient['calculation_use'] * $servingCount; // 必要量を計算

    // 各食材の在庫を取得
    $foods = $foodMasterDAO->get_foods_by_id_and_member($foodId, $memberId);

    try {
        foreach ($foods as $food) {
            $consume = min($calculationUse, $food['standard_gram']);
            $newAmount = $food['standard_gram'] - $consume;

            // ロットごとに在庫を更新
            $updateResult = $foodMasterDAO->update_food_amount_by_lot($foodId, $food['lot_no'], $newAmount);
            if (!$updateResult) {
                throw new Exception("ロット番号 {$food['lot_no']} の更新に失敗しました。");
            }

            if ($newAmount == 0) {
                $deleteResult = $registeredFoodDAO->delete_food_by_lot_no($food['lot_no']);
                if (!$deleteResult) {
                    throw new Exception("ロット番号 {$food['lot_no']} の削除に失敗しました。");
                }
            }

            $calculationUse -= $consume;
            if ($calculationUse <= 0) break; // 必要量が満たされたら終了
        }

        // 最後に正常に更新されたメッセージを返す
        echo json_encode([
            'success' => true,
            'message' => '在庫が正常に更新されました。'
        ], JSON_UNESCAPED_UNICODE);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => '在庫の更新中にエラーが発生しました。',
            'details' => $e->getMessage()
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}
