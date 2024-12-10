function showPopup(foodName) {
  const popup = document.getElementById('popup');
  const foodTitle = document.getElementById('popup-food-title');
  foodTitle.innerHTML = foodName + 'の登録'; // 食品名をポップアップに表示
  popup.style.display = 'block';  // ポップアップを表示
}

function closePopup() {
  const popup = document.getElementById('popup');
  popup.style.display = 'none';  // ポップアップを非表示
}

function submitForm() {
  const quantity = document.getElementById('quantity').value;
  const count = document.getElementById('count').value;
  const date = document.getElementById('date').value;

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "food_registration.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onload = function() {
    if (xhr.status === 200) {
      alert('食品情報が登録されました');
      closePopup(); 
    }
  };
  xhr.send(`quantity=${quantity}&count=${count}&date=${date}`);
}
