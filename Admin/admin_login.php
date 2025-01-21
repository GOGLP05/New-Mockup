<?php
require_once 'helpers/config.php';

try {
    // データベース接続
    $pdo = new PDO(DSN, DB_USER, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // フォーム入力を取得
    $admin_id = $_POST['admin_id'] ?? null;
    $password = $_POST['password'] ?? null;

    // 入力値のチェック
    if (!$admin_id || !$password) {
        throw new Exception("管理者IDとパスワードを入力してください。");
    }

    // SQLクエリの準備
    $sql = "SELECT * FROM admin WHERE admin_id = :admin_id AND password = :password";
    $stmt = $pdo->prepare($sql);

    // パラメータのバインドと実行
    $stmt->execute([
        ':admin_id' => $admin_id,
        ':password' => $password,
    ]);

    // 結果の取得
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // ログイン成功
        session_start(); // セッション開始
        $_SESSION['admin_id'] = $admin_id; // セッションに管理者IDを保存

        // admin_top.phpにリダイレクト
        header("Location: admin_top.php");
        exit;
    } else {
        // ログイン失敗
        echo "ログイン失敗: IDまたはパスワードが正しくありません。";
    }
} catch (Exception $e) {
    echo "エラー: " . $e->getMessage();
} catch (PDOException $e) {
    echo "データベースエラー: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ログイン</title>
    <link rel="stylesheet" href="admin_login.css">
</head>
<body>
    <h1>管理者ログイン</h1>
    <form method="post" action="admin_login.php">
    <label for="admin_id">管理者ID:</label>
    <input type="text" id="admin_id" name="admin_id" placeholder="管理者IDを入力" style="width: 250px;">

    <label for="password">パスワード:</label>
    <input type="password" id="password" name="password" placeholder="パスワードを入力" style="width: 250px;"><br>

    <button type="submit" style="width: 150px;">ログイン</button>
    </form>
</body>
</html>
