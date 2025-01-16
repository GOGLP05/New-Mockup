<?php
require_once 'helpers/MemberDAO.php';

$MemberDAO = new Member_DAO();
$member_list = $MemberDAO->get_members();

// 削除処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $member_id = trim($_POST['member_id']);

        // 削除実行
        $result = $MemberDAO->delete($member_id);

        // 削除結果を表示するためのメッセージを用意
        if ($result) {
            $message = "会員ID {$member_id} を削除しました。更新してください。";
        } else {
            $message = "会員ID {$member_id} は存在しません。";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員一覧</title>
    <link rel="stylesheet" href="admin_list_of_members.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- パンくずリスト -->
    <ul class="breadcrumb">
        <a href="admin_top.php">管理者TOP</a> >
        <span>会員一覧</span>
    </ul>

    <h1>会員一覧</h1>


    <table>
        <tr>
            <th>会員ID</th>
            <th>メールアドレス</th>
            <th>パスワード</th>
            <th>性別</th>
            <th>生年月日</th>
        </tr>
        <?php foreach ($member_list as $member) : ?>
            <tr>
                <td><?= htmlspecialchars($member->member_id, ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($member->email, ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($member->password, ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= $member->sex == 0 ? '男性' : ($member->sex == 1 ? '女性' : '未設定') ?></td>
                <td><?= htmlspecialchars($member->birthdate, ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- 削除ボタン -->
    <div class="mt-3">
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">削除</button>
    </div>


    <?php if (isset($message)) : ?>
        <div class="message"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <!-- モーダル -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">会員情報の削除</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="member_id" class="form-label">削除する会員IDを入力してください</label>
                            <input type="text" class="form-control" id="member_id" name="member_id" required>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-danger" name="delete">削除</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // モーダルが表示されたときに自動で入力欄にフォーカスを設定
        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('shown.bs.modal', () => {
            document.getElementById('member_id').focus();
        });
    </script>
</body>
</html>
