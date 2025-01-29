<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>فروشگاه کتاب</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>

    <?php
    include "Defult/header.php";
    include "Defult/config.php";
    ?>

    <!-- Main Content -->
    <main>
        <h2>کتاب ها </h2>
        <div class="book-container">
            <?php
                // get books from database
                $sql = "SELECT * FROM books LIMIT 10";
                $result = $conn->query($sql); 
                while($row = $result->fetch_assoc()) {
                    echo '<div class="book-card">';
                    echo '<img src="uploads/' . $row["image"] . '" alt="' . $row["title"] . '">';
                    echo '<h3>' . $row["title"] . '</h3>';
                    echo '<p>' . $row["description"] . '</p>';
                    echo '<p class="price">' . number_format($row["price"]) . ' ریال</p>';
                    echo '<a href="book.php?id=' . $row["id"] . '"><button class="add-to-cart">مشاهده</button></a>';
                    echo '</div>';
                }
                $conn->close();
            ?>
            
        </div>
    </main>

    <!-- Footer -->
    <?php
    include "Defult/footer.php";
    ?>

</body>
</html>
