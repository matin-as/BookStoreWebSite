<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <?php
        session_start();
        if (isset($_SESSION['username'])) 
        {
            header("Location: user/profile.php");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            include "Defult/config.php";
            $UserName = $_POST['username'];
            $Password = $_POST['password'];
            if (empty($UserName) || empty($Password)) {
                die("لطفاً تمامی فیلدها را پر کنید.");
            }
            $stmt = $conn->prepare("SELECT * FROM Users WHERE username = ? and password = ? ");
            $stmt->bind_param("ss", $UserName, $Password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) 
            {
                $_SESSION['username'] = $UserName;
                $_SESSION['email'] = $result->fetch_assoc()['email'];
                header("Location: user/profile.php");
            }
            else
            {
                echo "نام کاربری یا رمز عبور اشتباه است ";
            }
        }
    ?>
    <form action="/login.php" method="POST">
        <h1>صفحه ورود</h1>

        <label for="username">نام کاربری:</label>
        <input type="text" name="username" id="username" placeholder="نام کاربری خود را وارد کنید" required><br>

        <label for="password">رمز عبور:</label>
        <input type="password" name="password" id="password" placeholder="رمز عبور خود را وارد کنید" required><br>

        <input type="submit" value="ورود">
        <a href="forget.php">فراموشی رمز عبور</a>
    </form>
</body>
</html>
