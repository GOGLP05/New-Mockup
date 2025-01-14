// Show the popup
// Show the popup
function showPopup(foodName, foodId, memberId) {
  const popup = document.getElementById("popup");
  const title = document.getElementById("popup-food-title");
  title.textContent = foodName;
  popup.style.display = "block";

  // Store the food name, id, and member_id in hidden inputs
  const foodNameInput = document.getElementById("foodName");
  const foodIdInput = document.getElementById("foodId");
  const memberIdInput = document.getElementById("memberId"); // ここを追加

  foodNameInput.value = foodName;
  foodIdInput.value = foodId;
  memberIdInput.value = memberId; // member_idを設定
}

// Close the popup
function closePopup() {
  const popup = document.getElementById("popup");
  popup.style.display = "none";
}

// Submit form data
function submitForm() {
  const foodId = document.getElementById("foodId").value;
  const foodName = document.getElementById("foodName").value;
  const memberId = document.getElementById("memberId").value;
  const count = document.getElementById("count").value;
  const date = document.getElementById("date").value;

  console.log("Food ID:", foodId);
  console.log("Food Name:", foodName);
  console.log("Count:", count);
  console.log("Date:", date);

  // Send the data to the server
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
      console.error("エラー:", error);
      alert("通信エラーが発生しました。");
    });
}
