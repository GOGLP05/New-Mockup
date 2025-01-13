// Show the popup
function showPopup(foodName) {
    const popup = document.getElementById("popup");
    const title = document.getElementById("popup-food-title");
    title.textContent = foodName;
    popup.style.display = "block";

    // Store the food name in a hidden input for later
    const hiddenFoodNameInput = document.createElement("input");
    hiddenFoodNameInput.type = "hidden";
    hiddenFoodNameInput.id = "foodName";
    hiddenFoodNameInput.value = foodName;
    popup.appendChild(hiddenFoodNameInput);
}

// Close the popup
function closePopup() {
    const popup = document.getElementById("popup");
    popup.style.display = "none";
    document.getElementById("foodName").remove(); // Remove the hidden input
}

// Submit form data
function submitForm() {
    const foodName = document.getElementById("foodName").value;
    const count = document.getElementById("count").value;
    const date = document.getElementById("date").value;

    console.log("Food Name:", foodName);
    console.log("Count:", count);
    console.log("Date:", date);

    // Send the data to the server
    fetch("helpers/save_food_data.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            food_name: foodName,
            amount: count,  // Ensure the correct key is used here
            date: date
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            alert("登録が完了しました！");
            closePopup();
        } else {
            alert("エラーが発生しました：" + data.message);
        }
    })
    .catch(error => {
        console.error("エラー:", error);
        alert("通信エラーが発生しました。");
    });
}
