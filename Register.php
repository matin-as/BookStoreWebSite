<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ثبت نام</title>
    <link rel="stylesheet" href="css/Register.css">
</head>
<body>
    <?php
    //include 'db_connection.php';
    session_start();
    if (isset($_SESSION['username'])) 
    {
        header("Location: user/profile.php");
    }
        
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        include "Defult/config.php";
        $name = $_POST['name'];
        $lastname = $_POST['lastname'];
        $UserName = $_POST['username'];
        $Password = $_POST['password'];
        $email = $_POST['email'];
        $gender = ($_POST['checkbox'] === "مرد") ? 1 : 0;
        $emptyFields = [];

        if (empty($name)) {
            $emptyFields[] = "نام";
        }
        if (empty($lastname)) {
            $emptyFields[] = "نام خانوادگی";
        }
        if (empty($email)) {
            $emptyFields[] = "ایمیل";
        }
        if (empty($username)) {
            $emptyFields[] = "نام کاربری";
        }
        if (empty($Password)) {
            $emptyFields[] = "رمز عبور";
        }
        if (!empty($emptyFields)) {
            die("لطفاً فیلدهای زیر را پر کنید: " . implode(", ", $emptyFields));
        }
        if ($conn->connect_error) {
            die("اتصال به دیتابیس انجام نشد: " . $conn->connect_error);
        }
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
            $stmt->bind_param("ss", $email, $UserName);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows > 0) {
                echo "کاربر با این ایمیل یا نام کاربری قبلاً ثبت‌نام کرده است.";
            }
            else 
            {
                $stmt = $conn->prepare("INSERT INTO Users (name, lastname, email, username, password, gender) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssi", $name, $lastname, $email, $UserName, $Password, $gender);
                if ($stmt->execute()) {
                    $_SESSION['username'] = $UserName;
                    $_SESSION['email'] = $email;
                    header("Location: user/profile.php");
                } else {
                    echo "خطا در ثبت‌نام: " . $conn->error;
                }
            }
            $stmt->close();
            $conn->close();
    }
    ?>
    <form action="Register.php" method="POST">
        <h1>فرم ثبت نام</h1>
        <label for="name">اسم :</label>
        <input type="text" name="name" id="name"><br>
        <label for="lastname">نام خانوادگی :</label>
        <input type="text" name="lastname" id="lastname"><br>

        <label for="email">آدرس ایمیل :</label>
        <input type="email" name="email" id="email"><br>


        <label for="username">نام کاربری :</label>
        <input type="text" name="username" id="username"><br>
        <label for="password">رمز عبور :</label>
        <input type="password" name="password" id="password"><br>


        <label  for="checkbox">مرد</label>
        <input required type="radio" name="checkbox" id="checkbox" value="مرد">
        <label for="checkbox">زن</label>
        <input required type="radio" name="checkbox" id="checkbox" value="زن">


        <input type="submit" value="ثبت نام  " id="sub">
        <a href="Login.php">حساب دارید ؟</a>
    </form>
    
</body>
</html>