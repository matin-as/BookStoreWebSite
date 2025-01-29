<?php
// add to card 
    include "Defult/config.php";
    $id = $_POST["product_id"];
    // found book 
    $sql = "SELECT * FROM books WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // add book to card
            session_start();
            $_SESSION['numberproduct'] = $_SESSION['numberproduct'] + 1 ;
            $_SESSION['products'][] = array(
                'product_id' => $id,
                'product_name' => $row['title'],
                'product_price' => $row['price'],
                'product_image' => $row['image'],
                'product_description' => $row['description']
            );
        }
        $conn->close();
        echo "کتاب به صبد خرید اضافه شد ";
    } else {
        //echo ;
    }
?>