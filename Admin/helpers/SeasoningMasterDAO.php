<?php
 require_once 'DAO.php';

class SeasoningMaster{
    public int $seasoning_id;
    public string $seasoning_name;
    public  $unit;
}

    class SeasoningMasterDAO
    {
        public function get_seasonings() {
            $dbh = DAO::get_db_connect();
            $sql = "SELECT * FROM seasoning_master";
            $stmt = $dbh->query($sql);
            
            $seasonings = [];
            while ($seasoning = $stmt->fetchObject('SeasoningMaster')) {
                // unitがnullの場合、空文字をセット
                if ($seasoning->unit === null) {
                    $seasoning->unit = ''; // または適切なデフォルト値
                }
                $seasonings[] = $seasoning;
            }
            return $seasonings;
        }        public function get_seasoning_by_id($seasoning_id) {
            $dbh = DAO::get_db_connect(); // PDOインスタンスを取得
            $sql = "SELECT * FROM seasoning_master WHERE seasoning_id = :seasoning_id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':seasoning_id', $seasoning_id, PDO::PARAM_STR);
            $stmt->execute();
        
            return $stmt->fetchObject('SeasoningMaster'); // SeasoningMasterクラスのオブジェクトとして返す
        }
           
        public function delete_seasoning_by_id($seasoning_id) {
            $dbh = DAO::get_db_connect();
            $sql = "DELETE FROM seasoning_master WHERE seasoning_id = :seasoning_id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':seasoning_id', $seasoning_id, PDO::PARAM_STR);
            $result = $stmt->execute();
        
            // エラーハンドリングを追加
            if (!$result) {
                error_log("削除失敗: " . implode(" ", $stmt->errorInfo()));
            }
            return $result;
        }
        public function update_seasoning($seasoning_id, $seasoning_name) {
            $dbh = DAO::get_db_connect();
            $sql = "UPDATE seasoning_master SET seasoning_name = :seasoning_name WHERE seasoning_id = :seasoning_id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':seasoning_name', $seasoning_name, PDO::PARAM_STR);
            $stmt->bindValue(':seasoning_id', $seasoning_id, PDO::PARAM_STR);
            return $stmt->execute();
        }
    
        public function insert_seasoning($seasoning_id, $seasoning_name) {
            $dbh = DAO::get_db_connect();
            // SQL文を変更し、seasoning_idを含める
            $sql = "INSERT INTO seasoning_master (seasoning_id, seasoning_name) VALUES (:seasoning_id, :seasoning_name)";
            $stmt = $dbh->prepare($sql);
            
            // パラメータをバインド
            $stmt->bindValue(':seasoning_id', $seasoning_id, PDO::PARAM_STR);
            $stmt->bindValue(':seasoning_name', $seasoning_name, PDO::PARAM_STR);
            
            // 実行
            return $stmt->execute();
        }
                // 調味料名がすでに存在するか確認
    public function check_if_seasoning_exists($seasoning_name) {
        $dbh = DAO::get_db_connect();
        $sql = "SELECT COUNT(*) FROM seasoning_master WHERE seasoning_name = :seasoning_name";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':seasoning_name', $seasoning_name, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result > 0;
    }
    public function get_seasoning_by_name($seasoning_name) {
        $dbh = DAO::get_db_connect();
        
        // SQLクエリを準備
        $sql = "SELECT * FROM seasoning_master WHERE seasoning_name = :seasoning_name";
        
        // クエリを実行
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':seasoning_name', $seasoning_name, PDO::PARAM_STR);
        
        // 実行して結果を取得
        $stmt->execute();
        
        // 結果をフェッチして返す
        return $stmt->fetch(PDO::FETCH_OBJ); // 結果が1件の場合
    }
            }