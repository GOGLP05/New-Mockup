<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>パスワード再設定</title>
    <link rel="stylesheet" href="change_password_email.css">
</head>
<body>
    <h1>パスワード再設定</h1>
    <div class="container">
        <label for="user_email">メールアドレス</label>
        <input type="email" id="user_email" name="user_email" placeholder="メールアドレスを入力してください。" required>
        <button onclick="sendOtp()">メールを送信</button>
    </div>
    <script>
        function sendOtp() {
            const userEmail = document.getElementById('user_email').value;
            if (userEmail === "") {
                alert("メールアドレスを入力してください。");
                return;
            }

            // サーバーにメールアドレスを送信
            fetch('helpers/send_otp.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email: userEmail })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("ワンタイムパスコードが送信されました。メールを確認してください。");
                    window.location.href = 'verify_otp.html'; // OTP認証画面へリダイレクト
                } else {
                    alert("エラーが発生しました: " + data.message);
                }
            })
            .catch(error => console.error('エラー:', error));
        }
    </script>
</body>
</html>
