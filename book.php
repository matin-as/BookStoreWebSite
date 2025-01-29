<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>جزئیات کتاب</title>
    <link rel="stylesheet" href="css/book.css">
</head>
<body>
<?php
include "Defult/header.php";
include "Defult/config.php";
?>
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            if (!isset($_SESSION['username'])) 
            {
                header("Location: Login.php");
                exit;
            }

            $comment = $_POST["comment"];
            $UserName = $_SESSION['username'];

            // found user id 
            $stmt = $conn->prepare("SELECT * FROM Users WHERE username = ? ");
            $stmt->bind_param("s", $UserName);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id = $_GET['id'];
                    $stmt = $conn->prepare("INSERT INTO Comments (book_id, user_id, description) VALUES (?, ?, ?)");
                    $stmt->bind_param("iis", $id, $row['id'], $_POST["comment"]); // استفاده از 'id' از ردیف
                    if ($stmt->execute()) {
                        //echo "Okey";
                    } else {
                        echo " خطا در : " . $conn->error;
                    }
                }
            } else {
                echo "کاربری با این نام کاربری پیدا نشد.";
            }


        }
    ?>

    <!-- Main Content -->
    <main>
    <div class="book-detail">
        <?php
            $id = $_GET['id'];
            $sql = "SELECT * FROM books WHERE id = $id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $book = $result->fetch_assoc();
        ?>
                <img src="uploads/<?php echo $book['image']; ?>" alt="جلد کتاب">
                <div class="details">
                    <h2><?php echo $book['title']; ?></h2>
                    <p class="description"><?php echo $book['description']; ?></p>
                    <p class="price"><?php echo number_format($book['price']); ?> ریال</p>
                    <button data-id=<?php echo number_format($book['id']); ?>  id="addToCartBtn" class="add-to-cart">اضافه به سبد خرید</button>
                </div>
        <?php
            } else {
                echo "کتاب مورد نظر پیدا نشد.";
            }
        ?>
</div>


        <section class="reviews">
            <h3>نظرات کاربران</h3>
            <form action="" method="POST" class="review-form">
                <textarea id="comment" name="comment" placeholder="نظر خود را اینجا بنویسید..." required></textarea>
                <button type="submit" >ارسال نظر</button>
            </form>
            <div class="review-list">
                <?php
                // get all comments about this book 
                $sql = "SELECT * FROM comments WHERE book_id = $id LIMIT 10";
                $result = $conn->query($sql); 
                while($row = $result->fetch_assoc()) {
                    // get user by userID
                    $sql = "SELECT username FROM users WHERE id = $id LIMIT 1";
                    $resultInfo = $conn->query($sql); 
                    $UserInfo = $resultInfo->fetch_assoc();
                    echo '<div class="review">';
                    echo '<p><strong>' . $UserInfo["username"].'<br>' . '</strong>' . $row["description"] . '</p>';
                    echo '</div>';
                }
                $conn->close();
                ?>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <p>تمامی حقوق برای فروشگاه کتاب آنلاین محفوظ است.</p>
    </footer>

    <script>
        document.getElementById('addToCartBtn').addEventListener('click', function() {
            var productId = this.getAttribute('data-id');
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'add_to_cart.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert(xhr.responseText);
                } else {
                    alert('خطا در ارسال درخواست');
                }
            };

            var data = 'product_id=' + encodeURIComponent(productId);
            xhr.send(data);
        });
    </script>
</body>
</html>
