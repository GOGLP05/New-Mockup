function showPopup(foodName, useUnit) {
  console.log("showPopup called with:", { foodName, useUnit }); // デバッグ用
  const popup = document.getElementById("popup");
  if (!popup) {
    console.error("Popup element not found!");
    return;
  }

  const foodTitle = document.getElementById("popup-food-title");
  const quantityLabel = document.querySelector("label[for='quantity']");
  if (!foodTitle || !quantityLabel) {
    console.error("Required elements not found in the DOM!");
    return;
  }

  // 食品名をポップアップに表示
  foodTitle.innerHTML = foodName + "の登録";

  // use_unitに応じてラベルを切り替え
  if (useUnit === 0) {
    quantityLabel.textContent = "数量 (g)";
  } else if (useUnit === 1) {
    quantityLabel.textContent = "数量 (個)";
  }

  // ポップアップを表示
  popup.style.display = "block";
}

function closePopup() {
  const popup = document.getElementById("popup");
  popup.style.display = "none"; // ポップアップを非表示
}

function submitForm() {
  const quantity = document.getElementById("quantity").value;
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
  xhr.send(`quantity=${quantity}&count=${count}&date=${date}`);
}
