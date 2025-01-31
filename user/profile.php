<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پروفایل کاربری</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/profile.css">
</head>
<body>
<?php
    include "../Defult/header.php";
    include "../Defult/config.php";
    if (isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header("Location: /Site/");
        exit;
    }
?>
<main>
    <div class="profile-card">
        <img src="/images/profilepic.png" alt="عکس پروفایل" class="profile-img">
        <?php
            if (!isset($_SESSION['username'])) {
                header("Location: /Site/Register.php");
                exit;
            }
            echo "<h3>{$_SESSION['username']}</h3>";
            echo "<h3>{$_SESSION['email']}</h3>";
        ?>
        <p>آدرس: تهران، خیابان آزادی</p>
        <div class="buttons">
            <a href="editprofile.php" class="btn edit-profile">ویرایش پروفایل</a>
            <a href="orders.php" class="btn view-orders">مشاهده سفارشات</a>
            <a href="addaddress.php" class="btn add-address">افزودن آدرس</a>
            <form method="POST" action="" style="display: inline;">
                <button type="submit" name="logout" class="btn logout">خروج</button>
            </form>
        </div>
    </div>
</main>
<footer>
    <p>تمامی حقوق برای سایت محفوظ است.</p>
</footer>
</body>
</html>
