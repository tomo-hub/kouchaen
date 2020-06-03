<header>
    <a href="<?php print h(HOME_URL); ?>"><h1>こうちゃ園</h1></a>
    <p>紅茶専門ショップ</p>
    <ul>
        <li><?php print $name . '様'; ?></li> <!--ユーザ名-->
        <li><a href="<?php print h(LOGOUT_URL); ?>">ログアウト</a></li>
        <li><a href="<?php print h(CART_URL); ?>">トレー<span><?php print $totalcart; ?></span></a></li>
    </ul>
</header>