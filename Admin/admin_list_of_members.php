<?php

?>
<!DOCTYPE html>
<html lang="ja">
    <link rel="stylesheet" href="admin_list_of_members.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員一覧</title>
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- パンくずリスト -->
    <ul class="breadcrumb">
        <a href="admin_top.html">管理者TOP</a>>
        <span>会員一覧</span>
    </ul>

    <h1>会員一覧</h1>

    <table>
        <thead>
            <tr>
                <th>会員ID</th>
                <th>メールアドレス</th>
                <th>パスワード</th>
                <th>性別</th>
                <th>生年月日</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1001</td>
                <td>23jn0340</td>
                <td>23jn0340</td>
                <td>男</td>
                <td>2004/09/26</td>
                <td><button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#Modal">
                    削除</button>
                </td>
                
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
        <!-- モーダル -->
    <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">該当の会員情報を削除します</h5>
                    <p style="margin: 0;">会員ID:1001</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <p>削除する会員番号を入力</p>
                        <input type="text" class="form-control" name="popup_input" required>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-danger">削除</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
