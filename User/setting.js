document.getElementById("hamburger").addEventListener("click", function () {
    // ハンバーガーメニューのクラスをトグル
    document.querySelector(".menu-left").classList.toggle("open");
    // ハンバーガーのクロス用クラスをトグル
    document.body.classList.toggle("hamburger-active");
  });