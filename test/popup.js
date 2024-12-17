// script.js
document.addEventListener("DOMContentLoaded", () => {
    const popup = document.getElementById("popup");
    const openPopup = document.getElementById("openPopup");
    const closePopup = document.getElementById("closePopup");
    const form = document.getElementById("dataForm");
    const resultMessage = document.getElementById("resultMessage");

    // ポップアップを開く
    openPopup.addEventListener("click", () => {
        popup.classList.remove("hidden");
    });

    // ポップアップを閉じる
    closePopup.addEventListener("click", () => {
        popup.classList.add("hidden");
    });

    // フォーム送信
    form.addEventListener("submit", async (event) => {
        event.preventDefault();

        const grams = document.getElementById("grams").value;
        const quantity = document.getElementById("quantity").value;
        const date = document.getElementById("date").value;

        const data = { grams, quantity, date };

        // データベースへ送信
        try {
            const response = await fetch("register.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data),
            });

            const result = await response.json();

            if (result.success) {
                resultMessage.textContent = "データが正常に登録されました！";
            } else {
                resultMessage.textContent = "エラーが発生しました: " + result.message;
            }
        } catch (error) {
            resultMessage.textContent = "通信エラーが発生しました。";
            console.error(error);
        }

        popup.classList.add("hidden");
        form.reset();
    });
});
