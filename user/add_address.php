<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اضافه کردن آدرس</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/addaddress.css">
</head>
<body>
    <?php
    include "../Defult/header.php";
    include "../Defult/config.php";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ostan = $_POST['ostan'];
        $city = $_POST['city'];
        $post = $_POST['post'];
        $details = $_POST['details'];
        if (!empty($ostan) && !empty($city) && !empty($post) && !empty($details)) {



            // found user id 
            $stmt = $conn->prepare("SELECT * FROM Users WHERE username = ? ");
            $stmt->bind_param("s", $_SESSION['username']);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();


            $query = "INSERT INTO addresses (user_id, ostan, city, post, details) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("issss", $result['id'], $ostan, $city, $post, $details);

            if ($stmt->execute()) {
                echo "<p class='success-message'>آدرس با موفقیت اضافه شد.</p>";
            } else {
                echo "<p class='error-message'>خطایی رخ داد. لطفاً دوباره تلاش کنید.</p>";
            }

            $stmt->close();
        } else {
            echo "<p class='error-message'>لطفاً تمامی فیلدها را پر کنید.</p>";
        }
    }
    ?>

    <div class="form-container">
        <h1>اضافه کردن آدرس جدید</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="ostan">استان:</label>
                <input type="text" id="ostan" name="ostan" required>
            </div>

            <div class="form-group">
                <label for="city">شهر:</label>
                <input type="text" id="city" name="city" required>
            </div>

            <div class="form-group">
                <label for="post">کد پستی:</label>
                <input type="text" id="post" name="post" required>
            </div>

            <div class="form-group">
                <label for="details">جزئیات آدرس:</label>
                <textarea id="details" name="details" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn submit-btn">اضافه کردن آدرس</button>
            </div>
        </form>
    </div>

    <?php
    include "../Defult/footer.php";
    ?>
</body>
</html>
