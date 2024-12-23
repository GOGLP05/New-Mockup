<?php
require_once 'DAO.php';

class recipeMaster {
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
}

class Recipe_MasterDAO {
    // レシピ一覧を取得
    public function get_recipes() {
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
    public function get_recipe_by_id($id) {
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
    private function extract_processes($recipe) {
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
}
