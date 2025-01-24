// ポップアップを表示する関数
function showPopup(foodName, foodId, memberId, useUnit) {
  // ポップアップを表示
  document.getElementById("popup").style.display = "block";

  // フォームの各フィールドに値をセット
  document.getElementById("popup-food-title").textContent = foodName;
  document.getElementById("foodId").value = foodId;
  document.getElementById("memberId").value = memberId;
  document.getElementById("foodName").value = foodName;
  
  // クリックした食材のuseUnitを設定
  document.getElementById("useUnit").value = useUnit;

  // 個数のラベルを更新
  document.querySelector('label[for="count"]').textContent = `${useUnit}:`;
}


// ポップアップを閉じる関数
function closePopup() {
  document.getElementById("popup").style.display = "none";
}

function submitForm() {
  const foodIdElement = document.getElementById("foodId");
  if (!foodIdElement) {
    console.error("Food ID element not found!");
    alert("エラーが発生しました。");
    return;
  }

  const foodId = foodIdElement.value;
  const foodName = document.getElementById("foodName").value;
  const memberId = document.getElementById("memberId").value;
  const count = document.getElementById("count").value;
  const date = document.getElementById("date").value;
  const useUnit = document.getElementById("useUnit").value;

  console.log("Food ID:", foodId);
  console.log("Food Name:", foodName);
  console.log("Count:", count);
  console.log("Date:", date);
  console.log("Use Unit:", useUnit); 

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
    .then((response) => response.json())
    .then((data) => {
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
