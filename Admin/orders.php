<?php
include "../Defult/config.php";
include "../Defult/header.php";


if (isset($_POST['order_id']) && isset($_POST['status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];

    $update_query = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $new_status, $order_id);
    $stmt->execute();


    if ($stmt->affected_rows > 0) {
        echo "<p>وضعیت سفارش با موفقیت به روز شد.</p>";
    } else {
        echo "<p>خطا در به روزرسانی وضعیت سفارش.</p>";
    }
}


$order_query = "SELECT * FROM orders ORDER BY order_date DESC";
$stmt = $conn->prepare($order_query);
$stmt->execute();
$orders_result = $stmt->get_result();

if ($orders_result->num_rows == 0) {
    echo "<p>هیچ سفارشی ثبت نشده است.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت سفارشات</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/orders.css">
</head>
<body>

    <div class="orders-container">
        <h1>مدیریت سفارشات</h1>

        <?php while ($order = $orders_result->fetch_assoc()): ?>
            <div class="order">
                <div class="order-header">
                    <h2>سفارش شماره: <?php echo $order['id']; ?></h2>
                    <p><strong>تاریخ سفارش:</strong> <?php echo date("Y-m-d H:i:s", strtotime($order['order_date'])); ?></p>
                    <p><strong>وضعیت سفارش:</strong> <?php echo htmlspecialchars($order['status']); ?></p>
                    <p><strong>آدرس ارسال:</strong> <?php echo htmlspecialchars($order['address_id']); ?></p>
                    <p><strong>جمع کل:</strong> <?php echo number_format($order['total_price']); ?> ریال</p>
                </div>

                <div class="order-items">
                    <h3>جزئیات محصولات</h3>
                    <?php
                    $order_id = $order['id'];
                    $items_query = "SELECT oi.*, p.title, p.image FROM order_items oi JOIN books p ON oi.product_id = p.id WHERE oi.order_id = ?";
                    $items_stmt = $conn->prepare($items_query);
                    $items_stmt->bind_param("i", $order_id);
                    $items_stmt->execute();
                    $items_result = $items_stmt->get_result();

                    while ($item = $items_result->fetch_assoc()):
                    ?>
                        <div class="order-item">
                            <img src="http://localhost/Site/uploads/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                            <div class="order-item-details">
                                <h4><?php echo htmlspecialchars($item['title']); ?></h4>
                                <p>تعداد: <?php echo $item['quantity']; ?></p>
                                <p>قیمت واحد: <?php echo number_format($item['price']); ?> ریال</p>
                                <p>مجموع: <?php echo number_format($item['quantity'] * $item['price']); ?> ریال</p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                <form action=" " method="POST" class="status-form">
                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                    <label for="status_<?php echo $order['id']; ?>">وضعیت سفارش:</label>
                    <select name="status" id="status_<?php echo $order['id']; ?>">
                        <option value="در حال پردازش" <?php if ($order['status'] == "در حال پردازش") echo "selected"; ?>>در حال پردازش</option>
                        <option value="تحویل داده شده" <?php if ($order['status'] == "تحویل داده شده") echo "selected"; ?>>تحویل داده شده</option>
                        <option value="لغو شده" <?php if ($order['status'] == "لغو شده") echo "selected"; ?>>لغو شده</option>
                    </select>
                    <button type="submit">ثبت تغییرات</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>

    <?php include "../Defult/footer.php"; ?>
</body>
</html>
