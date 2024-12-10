<header>
    <div>
        <a href="">
            <img src="Group5(MosckUp)/New-Mockup" alt="いただきますlogo.png">
        </a>
    </div>
    <hr>
</header>
<div id = "link">
        <form action="index.php" method="GET">
            <input type="text" name="keyword" value="<?= @$keyword ?>">
            <input type="submit" value="検索">
        </form>

        <?php if(isset($member)): ?>
            <?=$member->membername?>さん
            <a href="cart.php">カート(<?=$num?>)</a>

            <a href="logout.php">ログアウト</a>
            <?php else: ?>
            <a href="login.php ">ログイン</a>
        <?php endif; ?>
    </div>
    <div id = "clear">
    <hr>
    </div>
</header>
