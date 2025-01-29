<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اضافه کردن مدیر </title>
    <link rel="stylesheet" href="../css/Register.css">
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        include "../Defult/config.php";
        $name = $_POST['name'];
        $lastname = $_POST['lastname'];
        $UserName = $_POST['username'];
        $Password = $_POST['password'];
        $email = $_POST['email'];
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
            $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ? OR username = ?");
            $stmt->bind_param("ss", $email, $UserName);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows > 0) {
                echo "کاربر با این ایمیل یا نام کاربری قبلاً ثبت‌نام کرده است.";
            }
            else 
            {
                $stmt = $conn->prepare("INSERT INTO admins (name, lastname, email, username, password) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $name, $lastname, $email, $UserName, $Password);
                if ($stmt->execute()) {
                    $_SESSION['username'] = $UserName;
                    $_SESSION['email'] = $email;
                    header("Location: admins.php");
                } else {
                    echo "خطا در ثبت‌نام: " . $conn->error;
                }
            }
            $stmt->close();
            $conn->close();
    }
    ?>
    <form action="" method="POST">
        <h1>اضاقه کردن مدیر</h1>
        <label for="name">اسم :</label>
        <input type="text" name="name" id="name" require><br>
        <label for="lastname">نام خانوادگی :</label>
        <input type="text" name="lastname" id="lastname" require><br>

        <label for="email">آدرس ایمیل :</label>
        <input type="email" name="email" id="email" require><br>


        <label for="username">نام کاربری :</label>
        <input type="text" name="username" id="username" require><br>
        <label for="password">رمز عبور :</label>
        <input type="password" name="password" id="password" require><br>


        <input type="submit" value="اضافه کردن مدیر " id="sub">
    </form>
    <?php
        include "../Defult/footer.php";
    ?>
</body>
</html>