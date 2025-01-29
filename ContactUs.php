<!DOCTYPE html>
<html lang="fa">
<head>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/main.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تماس با ما</title>
</head>
<body>
    <?php
        include "Defult/header.php";
        include "Defult/config.php";
        if (!isset($_SESSION['username'])) 
        {
            header("Location: Login.php");
        }
            
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            // found user 
            $stmt = $conn->prepare("SELECT * FROM Users WHERE username = ? ");
            $stmt->bind_param("s", $_SESSION['username']);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            // add messages

            $stmt = $conn->prepare("INSERT INTO messages (user_id, message) VALUES (?, ?)");
            $stmt->bind_param("ss", $result['id'], $_POST['Contact']);
            if ($stmt->execute()) {
                echo "پیام ارسال شد ";
                header("Location: user/profile.php");
            } else {
                echo "خطا در ثبت‌نام: " . $conn->error;
            }
        }
    ?>
    <form action="" method="POST">
        <h1>تماس با ما</h1>

        <label for="title">عنوان:</label>
        <input type="text" name="title" id="title" placeholder="عنوان خود را وارد کنید"><br>

        <label for="tel">شماره تلفن:</label>
        <input type="tel" name="tel" id="tel" placeholder="شماره تلفن خود را وارد کنید"><br>

        <label for="email">ایمیل:</label>
        <input type="email" name="email" id="email" placeholder="ایمیل خود را وارد کنید"><br>

        <label for="Contact">متن پیام:</label>
        <textarea name="Contact" id="Contact" placeholder="پیام خود را وارد کنید"></textarea><br>

        <input type="submit" value="ارسال">
    </form>
</body>
</html>
