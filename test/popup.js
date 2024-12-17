function showPopup(foodName) {
    // Set the food name dynamically
    document.getElementById("popup-food-title").textContent = foodName + "の情報を入力";
    document.getElementById("food-name").value = foodName; // Set the food name to a hidden field

    // Show the popup
    const popup = document.getElementById("popup");
    popup.style.display = "block";
}

function closePopup() {
    const popup = document.getElementById("popup");
    popup.style.display = "none";
}
