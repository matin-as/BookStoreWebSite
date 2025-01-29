
<header>
        <h1>فروشگاه کتاب آنلاین</h1>
</header>
    <nav>
        <a href="/Site/">خانه</a>
        <a href="/Site/About.php">درباره ما</a>
        <a href="/Site/ContactUs.php">تماس با ما</a>
        <?php
        session_start();
        $current_url = $_SERVER['REQUEST_URI'];
        if (!isset($_SESSION['username']) && (strpos($current_url, 'user/') !== false || strpos($current_url, 'card/') !== false)) {
            header("Location: /Site/Register.php");
            exit;
        }

        if (isset($_SESSION['username'])) 
        {
            echo '<a href="/Site/user/profile.php">پروفایل </a>';
            echo '<a href="/Site/card/card.php">سبد خرید </a>';
        }
        else
        {
            echo '<a href="/Site/Register.php">ورود</a>';
        }
        ?>
    </nav>