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
        SELECT food_name, display_use, calculation_use, use_unit 
        FROM recipe_ingredients 
        INNER JOIN food_master ON recipe_ingredients.food_id = food_master.food_id 
        INNER JOIN category ON food_master.category_id = category.category_id 
        WHERE recipe_ingredients.recipe_id = :recipeId
    ";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':recipeId', $recipeId, PDO::PARAM_INT); // recipe_idに基づいてバインド
    $stmt->execute();

    $ingredients = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ingredients[] = $row;
    }

    return $ingredients; // データがない場合は空配列を返す
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

                            //recipe_name,$recipe_file_path, $ingredients, $quantities_ing, $values_ing, $seasonings, $quantities_sea, $values_sea, $processList
    public function add_recipe($recipe_name,$recipe_file_path,$ingredients, $quantities_ing, $values_ing,$seasonings, $quantities_sea, $values_sea,$processList) {
        $i = 0;
        $processListInsert = "";
        $processListBind = "";
        for($i = 1; $i <= count($processList);$i++){
            $processListInsert .= ", process_".$i;

        }
        for($i = 1; $i <= count($processList);$i++){
            $processListBind .= ", :process_".$i;
        }
        //var_dump($processListInsert);
        //var_dump($processListBind);

        // 最新のレシピIDをselect
        $recipe_id= $this->get_next_recipe_id();
        $sql = "INSERT INTO recipe (recipe_id, recipe_name,recipe_file_path1".$processListInsert.") 
        VALUES (:recipe_id,:recipe_name,'/image/aiueo.jpg'".$processListBind.");";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
        $stmt->bindParam(':recipe_name', $recipe_name, PDO::PARAM_STR);
        //var_dump($processList);
        for($i = 1; $i <= count($processList);$i++){
            
            $stmt->bindParam(':process_'.($i), $processList['process_'.($i)], PDO::PARAM_STR);

        }


        $stmt->execute();

        // 最新のレシピIDをselect
        //$recipe_id= $this->get_next_recipe_id();

        //　食材リストにInsert
        $sql1 = "INSERT INTO recipe_ingredients(recipe_id,food_id,display_use,calculation_use)
                VALUES(:recipe_id,:food_id,:display_use,:calculation_use)";
          $stmt = $this->pdo->prepare($sql1);
          $stmt->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
          
          for($i = 0;$i < count($ingredients);$i++){
            $food_id = $ingredients[$i];  // 食材のIDを取得
            $stmt->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
            $stmt->bindParam(':food_id', $food_id, PDO::PARAM_INT);
            $stmt->bindParam(':display_use', $values_ing[$i], PDO::PARAM_STR);
            $stmt->bindParam(':calculation_use', $quantities_ing[$i], PDO::PARAM_INT);
            $stmt->execute();

          }
          
          


        //調味料リストにInsert
        $sql1 = "INSERT INTO Seasoning_Use(seasoning_id,recipe_id,display_use)
                VALUES(:seasoning_id,:recipe_id,:display_use)";
          $stmt = $this->pdo->prepare($sql1);
          $stmt->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);

          for($i = 0;$i < count($seasonings);$i++){
            $seasoning_id = $seasonings[$i];  // IDを取得
            $stmt->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
            $stmt->bindParam(':seasoning_id', $seasonings, PDO::PARAM_INT);
            $stmt->bindParam(':display_use', $values_sea[$i], PDO::PARAM_STR);
            $stmt->execute();

          }


        // SQL Server で IDENTITY を使用している場合は、SCOPE_IDENTITY() を使って新しく挿入されたIDを取得
       // $recipe_id = $this->pdo->query("SELECT SCOPE_IDENTITY()")->fetchColumn();

        // 取得したrecipe_idがNULLでないことを確認
       // if (!$recipe_id) {
      //      throw new Exception("レシピのID取得に失敗しました");

   // }
}
    
    // レシピを削除
    public function delete_recipe($recipe_id) {
        try {
            // トランザクション開始
            $this->pdo->beginTransaction();
    
            // 1. `recipe_ingredients` の関連データを削除
            $sql = "DELETE FROM recipe_ingredients WHERE recipe_id = :recipe_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
            $stmt->execute();
    
            // 2. `Seasoning_Use` の関連データを削除
            $sql = "DELETE FROM Seasoning_Use WHERE recipe_id = :recipe_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
            $stmt->execute();
    
            // 3. `recipe` テーブルから `recipe_id` を削除
            $sql = "DELETE FROM recipe WHERE recipe_id = :recipe_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
            $stmt->execute();
    
            // トランザクションを確定（コミット）
            $this->pdo->commit();
    
            return true; // 削除成功
        } catch (PDOException $e) {
            // エラーが発生した場合はロールバック（処理を取り消す）
            $this->pdo->rollBack();
    
            // エラーメッセージをログに記録（本番環境ではechoではなくログ推奨）
            error_log("Error deleting recipe: " . $e->getMessage());
    
            return false; // 削除失敗
        }
    }
    
//DELETE FROM recipe WHERE 


    
    public function get_next_recipe_id() {
        $dbh = DAO::get_db_connect();
        $sql = "SELECT MAX(recipe_id) + 1 AS next_id FROM recipe"; // セミコロンを追加
        $stmt = $dbh->prepare($sql);
        $stmt->execute(); // クエリを実行
        $row = $stmt->fetch();
        return $row['next_id'] ?? 1; // NULLなら1を返す
    }
        
}
    /*// food_file_path が空でない場合に更新
    if (!empty($food_file_path)) {
        $query .= ", food_file_path = ?";
    }*/
