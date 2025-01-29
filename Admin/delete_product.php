<?php

include "../Defult/config.php";
$data = json_decode(file_get_contents("php://input"), true);
if (isset($data['id'])) {
    $productId = $data['id'];


    $sql = "DELETE FROM books WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);

    if ($stmt->execute()) {
        echo "محصول با موفقیت حذف شد.";
    } else {
        echo "خطا در حذف محصول: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "شناسه محصول ارسال نشده است.";
}

$conn->close();
?>
