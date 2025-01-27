<?php
require_once 'RegisteredFoodDAO.php';
require_once 'DAO.php';

session_start();

if (!isset($_SESSION['member_id'])) {
    header('Location: login.php'); // ログインページへリダイレクト
    exit;
}

$lot_no = $_GET['lot_no'] ?? null;
if (!$lot_no) {
    header('Location: ../food_details.php'); // ロット番号がない場合は一覧ページにリダイレクト
    exit;
}

$RegisteredFoodDAO = new RegisteredFoodDAO();
try {
    $RegisteredFoodDAO->delete_food_by_lot_no($lot_no);
    header('Location: ../food_details.php'); // 削除後に一覧ページにリダイレクト
    exit;
} catch (Exception $e) {
    die('削除に失敗しました: ' . htmlspecialchars($e->getMessage()));
}
?>