<?php
// الاتصال بقاعدة البيانات
$conn = new mysqli("localhost", "root", "", "productsdxn");
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// استعلام جلب الفئات مع عدد المنتجات
$sql = "
    SELECT 
        categories.id,
        categories.name_cat,
        categories.img_cat,
        COUNT(product.id_pro) AS product_count
    FROM 
        categories
    LEFT JOIN 
        product ON product.id = categories.id
    GROUP BY 
        categories.id, categories.name_cat, categories.img_cat
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الأقسام</title>
    <!-- Bootstrap 5 RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        *{ font-family:'Cairo', sans-serif; }
        .card-img { height: 300px; object-fit: cover; }
        .about { margin-bottom: 4%; }
        .card .overlay {
            position: absolute; top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }
        .howwe {
            position: relative;
            z-index: 2;
          background: linear-gradient(to right, rgba(61, 120, 182, 1), rgba(179, 216, 255, 1));
            padding: 10px 150px;
            border-radius: 20px;
        }
    </style>
</head>
<body>

<!-- الهيدر -->
<div id="navbar-placeholder"></div>

<div class="card text-bg-dark about">
    <img src="https://th.bing.com/th/id/OIP.NUlwNjPkWPWiDx6B-3ZjyQHaEu?w=600" class="card-img" alt="...">
    <div class="overlay"></div>
    <div class="card-img-overlay d-flex justify-content-center align-items-center text-center">
        <div>
            <h5 class="card-title fs-1 howwe">الأقســام </h5>
        </div>
    </div>
</div>

<div class="container">
    <div class="row row-cols-1 row-cols-md-4 gx-4 gy-4 justify-content-center mb-5">
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $img = htmlspecialchars($row['img_cat']);
                $name = htmlspecialchars($row['name_cat']);
                $count = $row['product_count'];
                echo '
                <div class="col text-center">
                    <a href="products.php?cat_id=' . $row['id'] . '" class="text-decoration-none text-dark">
                        <img src="../' . $img . '" class="img-thumbnail" alt="' . $name . '">
                    </a>
              
          <a class="text-decoration-none text-dark" href="products.php?cat_id=' . $row['id'] . '">
         <h3 style="
        width: 300px;
        font-size: 20px;
        background: linear-gradient(to right, rgba(61, 120, 182, 1), rgba(179, 216, 255, 1));
        border-radius: 20px;
        padding: 10px;
        margin: 10px 0;
        text-align: center;
    ">
        (' . $count . ') ' . $name . '
          </h3>
     </a>

                </div>';
            }
        } else {
            echo '<p class="text-center">لا توجد بيانات لعرضها</p>';
        }
        ?>
    </div>
</div>

<!-- الفوتر -->
<div id="footer_p"></div>

<script>
    // تحميل الهيدر
    fetch("header.html")
        .then(res => res.ok ? res.text() : Promise.reject())
        .then(data => document.getElementById("navbar-placeholder").innerHTML = data)
        .catch(() => {
            document.getElementById("navbar-placeholder").innerHTML =
                '<nav class="navbar bg-light"><div class="container"><a class="navbar-brand" href="#">الرئيسية</a></div></nav>';
        });

    // تحميل الفوتر
    fetch("footer.html")
        .then(res => res.ok ? res.text() : Promise.reject())
        .then(data => document.getElementById("footer_p").innerHTML = data)
        .catch(() => {
            document.getElementById("footer_p").innerHTML =
                '<footer class="py-3 bg-light"><div class="container"><p class="text-center">© 2023 جميع الحقوق محفوظة</p></div></footer>';
        });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <a href="https://wa.me/967712016614?text=مرحبا%20نبيل%20صالح%20الجعفري" target="_blank" id="whatsapp-button"> <img src="https://img.icons8.com/color/48/000000/whatsapp.png" alt="WhatsApp"></a>
<style>
#whatsapp-button {
    position: fixed;
    bottom: 20px;
    right: 20px;
   

    z-index: 1000;
}
#whatsapp-button img {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
}
#whatsapp-button img:hover {
    transform: scale(1.1);
}
</style>
</body>
</html>

<?php
$conn->close();
?>
