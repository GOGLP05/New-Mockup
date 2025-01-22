// ポップアップを表示する関数
function showPopup(foodName, foodId, memberId, useUnit) {
  // ポップアップを表示
  document.getElementById("popup").style.display = "block";

  // フォームの各フィールドに値をセット
  document.getElementById("popup-food-title").textContent = foodName;
  document.getElementById("foodId").value = foodId;
  document.getElementById("memberId").value = memberId;
  document.getElementById("foodName").value = foodName;
  document.getElementById("useUnit").value = useUnit;

  // 個数のラベルを更新
  const countLabel = document.querySelector("label[for='count']");
  if (useUnit == 0) {
    // use_unitが0の場合、「g」を表示
    countLabel.textContent = "重量 (g):";
  } else if (useUnit == 1) {
    // use_unitが1の場合、「個」を表示
    countLabel.textContent = "個数:";
  }
}

// ポップアップを閉じる関数
function closePopup() {
  document.getElementById("popup").style.display = "none";
}

// フォームを送信する関数
function submitForm() {
  const foodId = document.getElementById("foodId").value;
  const foodName = document.getElementById("foodName").value;
  const memberId = document.getElementById("memberId").value;
  const count = document.getElementById("count").value;
  const date = document.getElementById("date").value;
  const useUnit = document.getElementById("useUnit").value;

  console.log("Food ID:", foodId);
  console.log("Food Name:", foodName);
  console.log("Count:", count);
  console.log("Date:", date);
  console.log("Use Unit:", useUnit); // useUnitの値をログに出力

  // サーバーにデータを送信
  fetch("helpers/save_food_data.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      food_id: foodId,
      food_name: foodName,
      member_id: memberId,
      amount: count,
      date: date,
      use_unit: useUnit,
    }),
  })
    .then((response) => {
      return response.json(); // レスポンスをJSONとして解析
    })
    .then((data) => {
      console.log("Response data:", data); // レスポンス内容を確認
      if (data.status === "success") {
        alert("登録が完了しました！");
        closePopup();
      } else {
        alert("エラーが発生しました：" + data.message);
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("通信エラーが発生しました。");
    });
}
