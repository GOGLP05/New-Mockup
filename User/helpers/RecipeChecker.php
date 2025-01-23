<?php
require_once 'helpers/DAO.php';

class RecipeChecker
{
    private $dbh;

    public function __construct()
    {
        // データベース接続の取得
        $this->dbh = DAO::get_db_connect();
    }

    public function getAvailableRecipes($member_id)
    {
        // レシピ情報（レシピ名、画像パス）を取得するクエリ
        $recipe_query = "
            SELECT r.recipe_id, r.recipe_name, r.recipe_file_path1
            FROM recipe r
            WHERE r.recipe_id IN (SELECT DISTINCT ri.recipe_id FROM recipe_ingredients ri)
        ";
        $recipe_stmt = $this->dbh->prepare($recipe_query);
        $recipe_stmt->execute();
        $recipes = $recipe_stmt->fetchAll(PDO::FETCH_ASSOC);

        // レシピと必要な食材の情報を取得するクエリ
        $ingredient_query = "
            SELECT 
                ri.recipe_id,
                ri.food_id,
                ri.calculation_use,
                COALESCE(SUM(rf.standard_gram), 0) AS standard_gram
            FROM recipe_ingredients ri
            LEFT JOIN registrated_food rf 
            ON ri.food_id = rf.food_id AND rf.member_id = :member_id
            GROUP BY ri.recipe_id, ri.food_id, ri.calculation_use
        ";
        $ingredient_stmt = $this->dbh->prepare($ingredient_query);
        $ingredient_stmt->execute([':member_id' => $member_id]);
        $ingredients = $ingredient_stmt->fetchAll(PDO::FETCH_ASSOC);

        // レシピの判定処理
        $recipe_status = [];
        foreach ($ingredients as $row) {
            $recipe_id = $row['recipe_id'];
            $required_amount = $row['calculation_use'];
            $available_amount = $row['standard_gram'];

            // レシピ初期化
            if (!isset($recipe_status[$recipe_id])) {
                $recipe_status[$recipe_id] = ['can_make' => true, 'details' => null]; // 初期状態は作成可能
            }

            // 必要量が不足している場合、作成不可に設定
            if ($available_amount < $required_amount) {
                $recipe_status[$recipe_id]['can_make'] = false;
            }
        }

        // レシピ名や画像パスを追加
        foreach ($recipes as $recipe) {
            $recipe_id = $recipe['recipe_id'];
            if (isset($recipe_status[$recipe_id])) {
                $recipe_status[$recipe_id]['details'] = [
                    'recipe_name' => $recipe['recipe_name'],
                    'recipe_file_path1' => $recipe['recipe_file_path1']
                ];
            }
        }

        // 作れるレシピと作れないレシピを分ける
        $available_recipes = [];
        $unavailable_recipes = [];
        foreach ($recipe_status as $recipe_id => $status) {
            $recipe_details = $status['details'];
            $recipe_name = $recipe_details['recipe_name'];
            $recipe_file_path1 = $recipe_details['recipe_file_path1'];

            if ($status['can_make']) {
                $available_recipes[] = [
                    'recipe_id' => $recipe_id,
                    'recipe_name' => $recipe_name,
                    'recipe_file_path1' => $recipe_file_path1
                ];
            } else {
                $unavailable_recipes[] = [
                    'recipe_id' => $recipe_id,
                    'recipe_name' => $recipe_name,
                    'recipe_file_path1' => $recipe_file_path1
                ];
            }
        }

        return [$available_recipes, $unavailable_recipes];
    }
}

// 使用例
//$member_id = 10000001; // ユーザーIDを指定
//$recipeChecker = new RecipeChecker();
//list($available_recipes, $unavailable_recipes) = $recipeChecker->getAvailableRecipes($member_id);

// 作れるレシピ
//echo "作れるレシピ:\n";
//foreach ($available_recipes as $recipe) {
//    echo "レシピID: {$recipe['recipe_id']}, 名前: {$recipe['recipe_name']}, 画像: {$recipe['recipe_file_path1']}\n";
//}

// 作れないレシピ
//echo "\n作れないレシピ:\n";
//foreach ($unavailable_recipes as $recipe) {
//    echo "レシピID: {$recipe['recipe_id']}, 名前: {$recipe['recipe_name']}, 画像: {$recipe['recipe_file_path1']}\n";
//}
