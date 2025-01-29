<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بررسی سفارش</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/review.css">
</head>
<body>
    <?php
    include "../Defult/header.php";
    include "../Defult/config.php";


    if (!isset($_POST['selected_address'])) {
        echo "<p>لطفاً ابتدا یک آدرس انتخاب کنید.</p>";
        exit;
    }

    $selected_address_id = $_POST['selected_address'];
    $query = "SELECT * FROM addresses WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $selected_address_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "<p>آدرس انتخاب شده نامعتبر است.</p>";
        exit;
    }

    $selected_address = $result->fetch_assoc();

    if (!isset($_SESSION['products']) || empty($_SESSION['products'])) {
        echo "<p>سبد خرید شما خالی است.</p>";
        exit;
    }

    $cart_items = $_SESSION['products'];
    $total_price = array_sum(array_column($cart_items, 'product_price'));
    ?>

    <div class="review-container">
        <h1>بررسی سفارش</h1>

        <div class="selected-address">
            <h2>آدرس انتخابی</h2>
            <p><strong>استان:</strong> <?php echo htmlspecialchars($selected_address['ostan']); ?></p>
            <p><strong>شهر:</strong> <?php echo htmlspecialchars($selected_address['city']); ?></p>
            <p><strong>کد پستی:</strong> <?php echo htmlspecialchars($selected_address['post']); ?></p>
            <p><strong>جزئیات:</strong> <?php echo htmlspecialchars($selected_address['details']); ?></p>
        </div>
        <div class="cart-items">
            <h2>لیست کتاب‌ها</h2>
            <?php foreach ($cart_items as $item): ?>
                <div class="cart-item">
                    <img src="http://localhost/Site/uploads/<?php echo htmlspecialchars($item['product_image']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>">
                    <div class="cart-item-details">
                        <h3><?php echo htmlspecialchars($item['product_name']); ?></h3>
                        <p><?php echo htmlspecialchars($item['product_description']); ?></p>
                        <p><?php echo number_format($item['product_price']); ?> ریال</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="total-price">
            <strong>جمع کل:</strong> <span><?php echo number_format($total_price); ?> ریال</span>
        </div>

        <div class="confirm-section">
            <form action="process_order.php" method="POST">
                <input type="hidden" name="selected_address_id" value="<?php echo $selected_address_id; ?>">
                <button type="submit" class="btn confirm-btn">تایید و ثبت سفارش</button>
            </form>
        </div>
    </div>

    <?php
    include "../Defult/footer.php";
    ?>
</body>
</html>
