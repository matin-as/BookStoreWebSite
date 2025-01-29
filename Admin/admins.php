<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>جدول مدیران</title>
    <link rel="stylesheet" href="../css/ProductsTable.css">
</head>
<body>
    <header>
        <h1>جدول مدیران</h1>
    </header>
    <?php
    include "../Defult/headeradmin.php";
    ?>

    <!-- Main Content -->
    <main>
        <section class="table-section">
            <h2>لیست مدیران</h2>
            <table>
                <thead>
                    <tr>
                        <th>شماره</th>
                        <th>نام</th>
                        <th>ایمیل</th>
                        <th>نقش</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "bookstore";
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    if ($conn->connect_error) {
                        die("خطا در اتصال به دیتابیس: " . $conn->connect_error);
                    }
                    $sql = "SELECT * FROM admins";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $counter = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $counter++ . "</td>";
                            echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                            echo "<td>" . "مدیر" . "</td>";
                            echo '<td>';
                            echo '<button class="delete-btn" onclick="deleteAdmin(' . $row["id"] . ')">حذف</button>';
                            echo '</td>';
                            echo "</tr>";
                        }
                    } else {
                        echo '<tr><td colspan="5">هیچ مدیری پیدا نشد.</td></tr>';
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <p>تمامی حقوق برای فروشگاه کتاب آنلاین محفوظ است.</p>
    </footer>

    <script>
        function deleteAdmin(adminId) {
            if (confirm("آیا از حذف این مدیر اطمینان دارید؟")) {
                fetch('delete_admin.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: adminId })
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
