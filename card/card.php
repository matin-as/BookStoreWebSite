<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سبد خرید</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/card.css">
</head>
<body>
    <?php
    include "../Defult/header.php";
    if (!isset($_SESSION['products']) || empty($_SESSION['products'])) {
        $cart_items = [];
        $total_price = 0;
    } else {
        $cart_items = $_SESSION['products'];
        $total_price = array_sum(array_column($cart_items, 'product_price'));
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_product'])) {
        $product_id_to_remove = $_POST['remove_product'];
        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id_to_remove) {
                unset($cart_items[$key]);
                break;
            }
        }
        $_SESSION['products'] = $cart_items;
        $total_price = array_sum(array_column($cart_items, 'product_price'));
    }
    ?>

    <div class="cart-container">
        <div class="cart-header">سبد خرید شما</div>

        <div id="cart-items">
            <?php if (!empty($cart_items)): ?>
                <?php foreach ($cart_items as $item): ?>
                    <div class="cart-item">
                        <img src="http://localhost/Site/uploads/<?php echo htmlspecialchars($item['product_image']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>">
                        <div class="cart-item-details">
                            <h4><?php echo htmlspecialchars($item['product_name']); ?></h4>
                            <p><?php echo htmlspecialchars($item['product_description']); ?></p>
                            <p><?php echo number_format($item['product_price']); ?> ریال</p>
                        </div>
                        <form method="POST" class="remove-form">
                            <input type="hidden" name="remove_product" value="<?php echo $item['product_id']; ?>">
                            <button type="submit" class="remove-btn">حذف</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>سبد خرید شما خالی است.</p>
            <?php endif; ?>
        </div>

        <div class="cart-footer">
            <div class="total-price">
                <strong>جمع کل: </strong><span id="total-price"><?php echo number_format($total_price); ?> ریال</span>
            </div>
            <?php if (!empty($cart_items)): ?>
                <button class="checkout-btn" onclick="checkout()">تسویه حساب</button>
            <?php endif; ?>
        </div>
    </div>
    <?php
    include "../Defult/footer.php";
    ?>
    <script>
        function checkout() {
            alert("شما به صفحه تسویه حساب منتقل خواهید شد.");
            window.location.href = "checkout.php";
        }
    </script>
</body>
</html>
