function showPopup(foodName, useUnit) {
  console.log("showPopup called with:", { foodName }); // デバッグ用
  const popup = document.getElementById("popup");
  if (!popup) {
    console.error("Popup element not found!");
    return;
  }

  const foodTitle = document.getElementById("popup-food-title");
  if (!foodTitle) {
    console.error("Required elements not found in the DOM!");
    return;
  }

  // 食品名をポップアップに表示
  foodTitle.innerHTML = foodName + "の登録";

  // ポップアップを表示
  popup.style.display = "block";
}

function closePopup() {
  const popup = document.getElementById("popup");
  popup.style.display = "none"; // ポップアップを非表示
}

function submitForm() {
  const count = document.getElementById("count").value;
  const date = document.getElementById("date").value;

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "food_registration.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onload = function () {
    if (xhr.status === 200) {
      alert("食品情報が登録されました");
      closePopup();
    }
  };
  xhr.send(`count=${count}&date=${date}`);
}
