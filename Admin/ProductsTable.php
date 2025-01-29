<?php

session_start();

include "../Defult/config.php";
include "../Defult/headeradmin.php";
if ($conn->connect_error) {
    die("خطا در اتصال به دیتابیس: " . $conn->connect_error);
}
$sql = "SELECT * FROM books";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $products = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $products = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>جدول محصولات</title>
    <link rel="stylesheet" href="../css/ProductsTable.css">
</head>
<body>
    <header>
        <h1>جدول محصولات</h1>
    </header>

    <!-- Main Content -->
    <main>
        <section class="table-section">
            <h2>لیست محصولات</h2>
            <table>
                <thead>
                    <tr>
                        <th>شماره</th>
                        <th>عنوان کتاب</th>
                        <th>نویسنده</th>
                        <th>قیمت (ریال)</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)) : ?>
                        <?php foreach ($products as $product) : ?>
                            <tr>
                                <td><?= htmlspecialchars($product['id']); ?></td>
                                <td><?= htmlspecialchars($product['title']); ?></td>
                                <td><?= htmlspecialchars($product['author']); ?></td>
                                <td><?= number_format($product['price']); ?> ریال</td>
                                <td>
                                    <button class="delete-btn" onclick="deleteProduct(<?= $product['id']; ?>)">حذف</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center;">محصولی یافت نشد.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <p>تمامی حقوق برای فروشگاه کتاب آنلاین محفوظ است.</p>
    </footer>
    <script>
        function deleteProduct(productId) {
            if (confirm("آیا از حذف این محصول اطمینان دارید؟")) {
                fetch('delete_product.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: productId })
                })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    location.reload();
                })
                .catch(error => {
                    console.error("خطا:", error);
                });
            }
        }
    </script>
</body>
</html>
