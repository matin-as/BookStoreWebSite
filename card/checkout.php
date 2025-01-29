<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>انتخاب آدرس</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/address.css">
</head>
<body>
    <?php
    include "../Defult/header.php";
    include "../Defult/config.php";
    $addresses = [];
    // found user 
    $stmt = $conn->prepare("SELECT * FROM Users WHERE username = ? ");
    $stmt->bind_param("s", $_SESSION['username']);
    $stmt->execute();
    $UserInfo = $stmt->get_result()->fetch_assoc();

    $query = "SELECT * FROM addresses WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $UserInfo['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $addresses[] = $row;
        }
    } else {
        echo "<p>هیچ آدرسی یافت نشد. لطفاً یک آدرس اضافه کنید.</p>";
    }

    $stmt->close();
    ?>

    <div class="address-container">
        <h1>انتخاب آدرس</h1>

        <form action="review.php" method="POST">
            <div class="address-list">
                <?php if (!empty($addresses)): ?>
                    <?php foreach ($addresses as $address): ?>
                        <div class="address-item">
                            <input 
                                type="radio" 
                                name="selected_address" 
                                id="address-<?php echo $address['id']; ?>" 
                                value="<?php echo $address['id']; ?>" 
                                required>
                            <label for="address-<?php echo $address['id']; ?>">
                                <h3>استان: <?php echo htmlspecialchars($address['ostan']); ?> - شهر: <?php echo htmlspecialchars($address['city']); ?></h3>
                                <p>کد پستی: <?php echo htmlspecialchars($address['post']); ?></p>
                                <p>جزئیات: <?php echo htmlspecialchars($address['details']); ?></p>
                            </label>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>شما هنوز هیچ آدرسی ثبت نکرده‌اید.</p>
                <?php endif; ?>
            </div>

            <div class="add-new-address">
                <a href="/Site/user/add_address.php" class="btn add-address-btn">افزودن آدرس جدید</a>
            </div>

            <div class="submit-section">
                <button type="submit" class="btn confirm-btn">تایید و ادامه</button>
            </div>
        </form>
    </div>

    <?php
    include "../Defult/footer.php";
    ?>
</body>
</html>
