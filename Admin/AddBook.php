<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>افزودن کتاب</title>
    <link rel="stylesheet" href="../css/addbook.css">
</head>
<body>
    <?php
        include "../Defult/config.php";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $author = $_POST['author'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                $image_info = pathinfo($_FILES['image']['name']);
                $image_extension = strtolower($image_info['extension']);
            
                if (in_array($image_extension, $allowed_extensions)) {
                    $upload_dir = '../uploads/';
                    $image_name = uniqid() . '.' . $image_extension;
                    $image_path = $upload_dir . $image_name;
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
                        $stmt = $conn->prepare("INSERT INTO books (title, author, price, description, image) VALUES (?, ?, ?, ?, ?)");
                        $stmt->bind_param("ssiss", $title, $author, $price, $description, $image_name);
                        if ($stmt->execute()) {
                            echo "کتاب با موفقیت افزوده شد.";
                        } else {
                            echo "خطا در افزودن کتاب.";
                        }
                        $stmt->close();
                        $conn->close();
                    } else {
                        echo "خطا در بارگذاری تصویر.";
                    }
                } else {
                    echo "فرمت تصویر مجاز نیست.";
                }
            } else {
                echo "لطفاً تصویر جلد کتاب را انتخاب کنید.";
            }
        }
    ?>
    <header>
        <h1>افزودن کتاب جدید</h1>
    </header>
    <?php
    include "../Defult/headeradmin.php";
    ?>

    <!-- Main Content -->
    <main>
        <section class="form-section">
            <h2>فرم افزودن کتاب</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">عنوان کتاب:</label>
                    <input type="text" id="title" name="title" placeholder="عنوان کتاب را وارد کنید" required>
                </div>

                <div class="form-group">
                    <label for="author">نویسنده:</label>
                    <input type="text" id="author" name="author" placeholder="نام نویسنده را وارد کنید" required>
                </div>

                <div class="form-group">
                    <label for="price">قیمت (ریال):</label>
                    <input min="0" type="number" id="price" name="price" placeholder="قیمت کتاب را وارد کنید" required>
                </div>

                <div class="form-group">
                    <label for="description">توضیحات:</label>
                    <textarea id="description" name="description" placeholder="توضیحات در مورد کتاب" rows="5" required></textarea>
                </div>

                <div class="form-group">
                    <label for="image">تصویر جلد کتاب:</label>
                    <input type="file" id="image" name="image" accept="image/*" required>
                </div>

                <button type="submit" class="submit-btn">افزودن کتاب</button>
            </form>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <p>تمامی حقوق برای فروشگاه کتاب آنلاین محفوظ است.</p>
    </footer>
</body>
</html>
