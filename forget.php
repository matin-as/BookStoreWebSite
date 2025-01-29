<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فراموشی رمز عبور</title>
    <link rel="stylesheet" href="css/forget.css">
</head>
<body>
    <?php
    include "Defult/config.php";
    

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST["email"]);
        if (!empty($email)) {
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $new_password = bin2hex(random_bytes(4));
                $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
                $update_stmt->bind_param("ss", $new_password, $email);
                if ($update_stmt->execute()) {
                    $to = $email;
                    $subject = "بازیابی رمز عبور";
                    $message = "رمز عبور جدید شما: " . $new_password;
                    $headers = "From: mtasad2008@gmail.com\r\n";
                    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

                    if (mail($to, $subject, $message, $headers)) {
                        echo "<p style='color: green;'>رمز عبور جدید برای شما ارسال شد.</p>";
                    } else {
                        echo "<p style='color: red;'>خطا در ارسال ایمیل. لطفاً دوباره تلاش کنید.</p>";
                    }
                } else {
                    echo "<p style='color: red;'>خطا در به‌روزرسانی رمز عبور. لطفاً دوباره تلاش کنید.</p>";
                }
            } else {
                echo "<p style='color: red;'>ایمیل وارد شده در سیستم موجود نیست.</p>";
            }
        } else {
            echo "<p style='color: red;'>لطفاً ایمیل خود را وارد کنید.</p>";
        }
    }
    ?>
    <form action="" method="POST">
        <h1>فراموشی رمز عبور</h1>

        <label for="email">ایمیل خود را وارد کنید:</label>
        <input type="email" name="email" id="email" placeholder="ایمیل خود را وارد کنید" required><br>

        <input type="submit" value="بازیابی رمز عبور">
        <a href="login.php">بازگشت به صفحه ورود</a>
    </form>
    <?php
    include "Defult/footer.php";
    ?>
</body>
</html>
