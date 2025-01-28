<?php
require_once 'DAO.php';

class Recipe {
    public int $recipe_id;
    public string $recipe_name;
    public string $recipe_file_path1;
    public array $processes = [];
    public array $ingredients = [];
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
}

class RecipeDAO {
        private $pdo; // プロパティを明示的に宣言
    
        public function __construct() {
            $this->pdo = DAO::get_db_connect(); // 宣言済みプロパティを利用
        }
    
    // レシピ一覧を取得
    public function get_recipes() {
        $dbh = DAO::get_db_connect();
        $sql = "SELECT * FROM recipe";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();

        $data = [];
        while ($row = $stmt->fetchObject('Recipe')) {
            $data[] = $row;
        }
        return $data;
    }

    // レシピIDで詳細を取得
    public function get_recipe_by_id($id) {
        $dbh = DAO::get_db_connect();
        $sql = "SELECT * FROM recipe WHERE recipe_id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $recipe = $stmt->fetchObject('Recipe');

        if ($recipe) {
            // プロセス情報を配列に整形
            $recipe->processes = $this->extract_processes($recipe);
            // 材料情報を取得
            $recipe->ingredients = $this->get_ingredients_by_recipe_id($id);
        }

        return $recipe;
    }

    // プロセス情報を配列に変換
    private function extract_processes($recipe) {
        $processes = [];
        for ($i = 1; $i <= 10; $i++) {
            $property = "process_$i";
            if (!empty($recipe->$property)) {
                $processes[] = preg_replace('/\r\n|\r|\n/', "\n", $recipe->$property); // 改行コードを正規化
            }
        }
        return $processes;
    }

    // レシピIDに基づいて材料を取得
    public function get_ingredients_by_recipe_id($recipeId) {
        $dbh = DAO::get_db_connect();
        $sql = "
            SELECT fm.food_name, ri.calculation_use, ri.display_use
            FROM recipe_ingredients ri
            JOIN food_master fm ON ri.food_id = fm.food_id
            WHERE ri.recipe_id = :recipeId
        ";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':recipeId', $recipeId, PDO::PARAM_INT);
        $stmt->execute();

        $ingredients = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ingredients[] = $row;
        }

        return $ingredients ?: []; // データがない場合は空配列を返す
    }

    // レシピに必要な調味料を取得
    public function get_seasonings_by_recipe_id($recipeId) {
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

        return $seasonings ?: [];
    }

    // カテゴリーIDで使用単位を取得
    public function get_use_unit_by_category_id($categoryId) {
        $dbh = DAO::get_db_connect();
        $sql = "SELECT use_unit FROM category WHERE category_id = :category_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['use_unit'] ?? '0'; // データがない場合はデフォルトで '0' を返す
    }


    // 食品リストを取得
    public function get_all_foods() {
        $sql = "SELECT food_id, food_name FROM food_master ORDER BY food_name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 調味料リストを取得
    public function get_all_seasonings() {
        $sql = "SELECT seasoning_id, seasoning_name FROM seasoning_master ORDER BY seasoning_name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
