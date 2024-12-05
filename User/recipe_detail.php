<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>レシピ</title>
    <link rel="stylesheet" href="recipe_detail.css"> <!-- 外部CSSファイルをリンク -->
</head>
<body>

    <div class="hamburger-menu"></div>
    <input id="menu__toggle" type="checkbox" />
    <label class="menu__btn" for="menu__toggle">
      <span></span>
    </label>

    <ul class="menu__box">
      <li><a class="menu__item" href="setting.html">設定</a></li>
      <li><a class="menu__item" href="list_of_food.html">食品庫</a></li>
      <li><a class="menu__item" href="list_of_food_registration.html">食品登録</a></li>
      <li><a class="menu__item" href="top.html">TOP</a></li>
    </ul>
  </div>

    <div class="content">
        <div class="photo">
            <img src="User\img\nikujaga.jpg" alt="肉じゃがの写真">
        </div>
        <div class="details">
            <h1>肉じゃが</h1>
            <p class="servings">1人分</p>
            <div class="ingredients">
                <h2>材料</h2>
                <ul>
                    <li><span class="ingredients-name">じゃがいも</span><span class="ingredients-quantity">3個(2個不足)</span></li>
                    <li><span class="ingredients-name">玉ねぎ</span><span class="ingredients-quantity">1/2個</span></li>
                    <li><span class="ingredients-name">にんじん</span><span class="ingredients-quantity">1/2本</span></li>
                    <li><span class="ingredients-name">牛肉</span><span class="ingredients-quantity">100g</span></li>
                    <li><span class="ingredients-name">しらたき</span><span class="ingredients-quantity">100g</span></li>
                    <li><span class="ingredients-name">サラダ油</span><span class="ingredients-quantity">小さじ2</span></li>
                    <li><span class="ingredients-name">かつおだし</span><span class="ingredients-quantity">1と1/2カップ</span></li>
                    <li><span class="ingredients-name">しょうゆ</span><span class="ingredients-quantity">大さじ2</span></li>
                    <li><span class="ingredients-name">みりん</span><span class="ingredients-quantity">大さじ2</span></li>
                </ul>
            </div>
            <div class="steps">
                <h2>手順</h2>
                <ol>
                    <li>じゃがいもはひと口大に切って水にさらし、水気をきる。玉ねぎはくし形切り、にんじんは乱切りにする。牛肉はひと口大に切る。しらたきはゆでて食べやすく切る。</li>
                    <li>鍋に油を熱して（１）の玉ねぎを炒め、牛肉を加えてさらに炒める。にんじん、じゃがいも、しらたきも入れて炒め合わせる。</li>
                    <li>かつおだしを注ぎ、沸騰したらアクを取り、しょうゆ、みりんを加えて落しぶたをする。沸騰したら弱火で１５分くらい煮る。</li>
                </ol>
                <p class="url">URL</p>
            </div>
            <!--<button type="button" aria-label="減らす" aria-describedby="label-number-of-unit">-</button>-->
            <input type="number" id="number-of-unit" name="unit" value="1" min="0" max="10">人前
           
            <!-- <button type="button" aria-label="増やす" aria-describedby="label-number-of-unit">+</button>人前-->
            <!--<div class="visually-hidden" role="status" aria-live="polite">{input 要素内の値がここに代入される。}</div>-->



            <button class="make"><a href="#">作った</a></button>
        </div>
    </main>
</div>
</body>
</html>