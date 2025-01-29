<?php
session_start();
include "../Defult/config.php";

if (!isset($_POST['selected_address_id']) || empty($_SESSION['products'])) {
    echo "<p>لطفاً ابتدا یک آدرس انتخاب کنید و سبد خرید خود را پر کنید.</p>";
    exit;
}

$selected_address_id = $_POST['selected_address_id'];

// found user 
$stmt = $conn->prepare("SELECT * FROM Users WHERE username = ? ");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$UserInfo = $stmt->get_result()->fetch_assoc();
$query = "SELECT * FROM addresses WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $selected_address_id, $UserInfo['id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<p>آدرس انتخابی معتبر نیست.</p>";
    exit;
}

$selected_address = $result->fetch_assoc();

$total_price = 0;
foreach ($_SESSION['products'] as $item) {
    $total_price += $item['product_price'];
}

$order_query = "INSERT INTO orders (user_id, address_id, total_price, status, order_date) VALUES (?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($order_query);
$order_status = 'در حال پردازش';
$stmt->bind_param("iiis", $UserInfo["id"], $selected_address_id, $total_price, $order_status);

if ($stmt->execute()) {
    $order_id = $stmt->insert_id; 
    $order_items_query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
    $order_item_stmt = $conn->prepare($order_items_query);

    foreach ($_SESSION['products'] as $item) {
        $product_id = $item['product_id'];
        $quantity = 1; 
        $price = $item['product_price'];

        $order_item_stmt->bind_param("iiii", $order_id, $product_id, $quantity, $price);
        $order_item_stmt->execute();
    }

    unset($_SESSION['products']);
    header("Location: /Site/user/profile.php");
    exit;
} else {
    echo "<p>خطا در ثبت سفارش. لطفاً دوباره تلاش کنید.</p>";
}

?>
