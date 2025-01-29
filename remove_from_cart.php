<?php
session_start();
if (isset($_POST['product_id']) && is_numeric($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    if (isset($_SESSION['products']) && !empty($_SESSION['products'])) {
        foreach ($_SESSION['products'] as $key => $item) {
            if ($item['product_id'] == $product_id) {
                unset($_SESSION['products'][$key]);
                break;
            }
        }
        $total_price = 0;
        if (!empty($_SESSION['products'])) {
            $total_price = array_sum(array_column($_SESSION['products'], 'product_price'));
        }
        echo number_format($total_price);
    } else {
        echo "سبد خرید شما خالی است.";
    }
} else {
    echo "خطا: شناسه محصول معتبر نیست.";
}
?>