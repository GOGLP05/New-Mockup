<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ポップアップフォーム</title>
    <link rel="stylesheet" href="popup.css">
</head>
<body>
    <button id="openPopup">食品を登録する</button>

    <div id="popup" class="popup hidden">
        <div class="popup-content">
            <h2>データを登録</h2>
            <form id="dataForm">
                <h3>食品名: 牛乳</h3>

                <h3>グラム:</h3>
                <input type="number" id="grams" name="grams" min="1" required>

                <h3>個数:</h3>
                <input type="number" id="quantity" name="quantity" min="1" required>

                <h3>登録日:</h3>
                <input type="date" id="date" name="date" required>

                <button type="submit">登録</button>
                <button type="button" id="closePopup">キャンセル</button>
            </form>
        </div>
    </div>

    <div id="resultMessage"></div>

    <script src="popup.js"></script>
</body>
</html>
