<?php
session_start();

include "../Defult/config.php";
if ($conn->connect_error) {
    die("خطا در اتصال به دیتابیس: " . $conn->connect_error);
}

$sql = "SELECT messages.id, messages.user_id, messages.message, users.name, users.email 
        FROM messages 
        JOIN users ON messages.user_id = users.id";
$result = $conn->query($sql);
$messages = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>پیام‌های دریافتی</title>
    <link rel="stylesheet" href="../css/ProductsTable.css">
</head>
<body>
    <header>
        <h1>پیام‌های دریافتی</h1>
    </header>
    <?php include "../Defult/headeradmin.php"; ?>
    
    <!-- Main Content -->
    <main>
        <section class="messages-section">
            <h2>لیست پیام‌ها</h2>
            <table>
                <thead>
                    <tr>
                        <th>شماره</th>
                        <th>نام</th>
                        <th>ایمیل</th>
                        <th>پیام</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($messages)) : ?>
                        <?php foreach ($messages as $message) : ?>
                            <tr>
                                <td><?= htmlspecialchars($message['id']); ?></td>
                                <td><?= htmlspecialchars($message['name']); ?></td>
                                <td><?= htmlspecialchars($message['email']); ?></td>
                                <td><?= nl2br(htmlspecialchars($message['message'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align: center;">هیچ پیامی یافت نشد.</td>
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
</body>
</html>