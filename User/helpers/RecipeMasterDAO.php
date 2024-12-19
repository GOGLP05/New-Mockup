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

class Recipe_MasterDAO{
    public function get_recipes() {
        $dbh = DAO::get_db_connect();
        $sql = "SELECT * FROM recipe";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $data = [];
        // In Recipe_MasterDAO class
while ($row = $stmt->fetchObject('recipeMaster')) {
    $data[] = $row;
}

        return $data;
    }
}