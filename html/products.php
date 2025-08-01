<?php
// الاتصال بقاعدة البيانات
$conn = new mysqli("localhost", "root", "", "productsdxn");
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// التحقق من وجود id الفئة
$cat_id = isset($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
if ($cat_id <= 0) {
    die("فئة غير صالحة");
}

// جلب اسم الفئة
$cat_name = "منتجات";
$cat_sql = "SELECT name_cat FROM categories WHERE id = $cat_id LIMIT 1";
$cat_result = $conn->query($cat_sql);
if ($cat_result && $cat_result->num_rows > 0) {
    $cat_name = $cat_result->fetch_assoc()['name_cat'];
}

// جلب المنتجات
$sql = "SELECT *FROM product WHERE id = $cat_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($cat_name); ?></title>
    <!-- Bootstrap + Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
            * {  font-family: 'Cairo', sans-serif; }
    .card-img-top { height: 200px; object-fit: cover; }
    
    .card.text-bg-dark .card-img {
        height: 40vh; /* ربع الصفحة */
        object-fit: cover;
    }

    .about { margin-bottom: 4%; }
    
    .overlay {
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
            <h5 class="card-title fs-1 howwe"><?php echo htmlspecialchars($cat_name); ?></h5>
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $name = htmlspecialchars($row['name_pro']);
                $desc = htmlspecialchars($row['des_pro']);
                $img = htmlspecialchars($row['img_pro']);
                $id_pro = htmlspecialchars($row['id_pro']);
                $price = htmlspecialchars($row['price']);

echo '
<div class="col">
<a href="piece.php?id=' . $id_pro . '" class="text-decoration-none text-dark">
    <div class="card h-100">
        <img src="../' . $img . '" class="card-img-top h-75" alt="' . $name . '">
        <div class="card-body d-flex flex-column justify-content-between">
            <div>
                <h3 class="card-title text-center">' . $name . '</h3>
            </div>
            <div class="text-end mt-3">
                <span class="badge bg-success fs-6">السعر: ' . $price . ' ريال</span>
            </div>
        </div>
    </div>
</a>
</div>';


            }
        } else {
            echo '<div class="text-center"><p>لا توجد منتجات في هذه الفئة.</p></div>';
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

<?php $conn->close(); ?>
