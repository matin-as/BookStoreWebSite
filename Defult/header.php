
<header>
        <h1>فروشگاه کتاب آنلاین</h1>
</header>
    <nav>
        <a href="/">خانه</a>
        <a href="/About.php">درباره ما</a>
        <a href="/ContactUs.php">تماس با ما</a>
        <?php
        session_start();
        $current_url = $_SERVER['REQUEST_URI'];
        if (!isset($_SESSION['username']) && (strpos($current_url, 'user/') !== false || strpos($current_url, 'card/') !== false)) {
            header("Location: /Site/Register.php");
            exit;
        }

        if (isset($_SESSION['username'])) 
        {
            echo '<a href="/user/profile.php">پروفایل </a>';
            echo '<a href="/card/card.php">سبد خرید </a>';
        }
        else
        {
            echo '<a href="/Register.php">ورود</a>';
        }
        ?>
    </nav>