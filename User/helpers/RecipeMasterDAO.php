<?php
require_once 'DAO.php';

class recipeMaster
{
    public int $recipe_id;
    public string $recipe_name;
    public string $recipe_file_path1;
    public ?string $process_1;
    public ?string $process_2;
    public ?string $process_3;
    public ?string $process_4;
    public ?string $process_5;
    public ?string $process_6;
    public ?string $process_7;
    public ?string $process_8;
    public ?string $process_9;
    public ?string $process_10;

    // 修正: プロパティ $processes を追加
    public array $processes = [];
}

class Recipe_MasterDAO
{
    // レシピ一覧を取得
    public function get_recipes()
    {
        $dbh = DAO::get_db_connect();
        $sql = "SELECT recipe_id, recipe_name, recipe_file_path1 FROM recipe";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $data = [];

        while ($row = $stmt->fetchObject('recipeMaster')) {
            $data[] = $row;
        }

        return $data;
    }

    // レシピIDに基づいて詳細を取得
    public function get_recipe_by_id($id)
    {
        $dbh = DAO::get_db_connect();
        $sql = "SELECT * FROM recipe WHERE recipe_id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $recipe = $stmt->fetchObject('recipeMaster');

        // プロセスを配列として整形
        if ($recipe) {
            $recipe->processes = $this->extract_processes($recipe);
        }

        return $recipe;
    }

    // プロセス情報を配列に変換
    private function extract_processes($recipe)
    {
        $processes = [];
        for ($i = 1; $i <= 10; $i++) {
            $property = "process_$i";
            if (!empty($recipe->$property)) {
                // 改行コードの正規化
                $processes[] = preg_replace('/\r\n|\r|\n/', "\n", $recipe->$property);
            }
        }
        return $processes;
    }
    public function get_foods_sorted_by_registration_date()
    {
        $dbh = DAO::get_db_connect();
        $sql = "SELECT * FROM food_master ORDER BY registration_date DESC";  // 登録日で降順に並び替え
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $data = [];
        while ($row = $stmt->fetchObject('foodMaster')) {
            $data[] = $row;
        }
        return $data;
    }

    public function get_ingredients_by_recipe_id($recipeId)
    {
        $dbh = DAO::get_db_connect();
        $sql = "SELECT food_id, calculation_use FROM recipe_ingredients WHERE recipe_id = :recipe_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':recipe_id', $recipeId, PDO::PARAM_INT);
        $stmt->execute();

        $ingredients = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ingredients[] = $row;
        }
        return $ingredients;
    }

    // レシピに必要な調味料を取得（前回と同様）
    public function get_seasonings_by_recipe_id($recipeId)
    {
        $dbh = DAO::get_db_connect();
        $sql = "
            SELECT sm.seasoning_name, sm.unit, su.display_use
            FROM seasoning_master sm
            JOIN seasoning_use su ON sm.seasoning_id = su.seasoning_id
            WHERE su.recipe_id = :recipeId
        ";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':recipeId', $recipeId, PDO::PARAM_INT);
        $stmt->execute();
        $seasonings = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $seasonings[] = $row;
        }

        return $seasonings;
    }

    public function get_use_unit_by_category_id($categoryId)
    {
        $dbh = DAO::get_db_connect();
        // ここではSQLを使用してカテゴリーのuse_unitを取得
        // 例：カテゴリーテーブルからcategory_idに基づいてuse_unitを取得する
        $sql = "SELECT use_unit FROM category WHERE category_id = :category_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['use_unit'] : 0; // デフォルトで '0'（個）
    }
}
