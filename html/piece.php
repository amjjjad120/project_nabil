<?php
// الاتصال بقاعدة البيانات
$conn = new mysqli("localhost", "root", "", "productsdxn");
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($product_id <= 0) {
    die("منتج غير صالح");
}

// جلب بيانات المنتج
$sql = "SELECT *FROM product WHERE id_pro = $product_id LIMIT 1";
$result = $conn->query($sql);
if (!$result || $result->num_rows == 0) {
    die("المنتج غير موجود");
}

$product = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name_pro']); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * {  font-family: 'Cairo', sans-serif; }
        .product-img { max-height: 400px; object-fit: cover; border-radius: 10px; }
        .quantity-input { max-width: 100px; }
    </style>
</head>
<body>

<!-- الهيدر -->
<div id="navbar-placeholder" ></div>

<div class="container" style="margin-top: 8%;" >
    <div class="row g-4 align-items-center">
        <div class="col-md-6 text-center">
            <img src="../<?php echo htmlspecialchars($product['img_pro']); ?>" class="img-fluid product-img" alt="<?php echo htmlspecialchars($product['name_pro']); ?>">
        </div>
        <div class="col-md-6">
            <h2><?php echo htmlspecialchars($product['name_pro']); ?></h2>
            <p><?php echo nl2br(htmlspecialchars($product['des_pro'])); ?></p>

           <form id="add-to-cart-form">
    <div class="mb-3">
        <label for="quantity" class="form-label">الكمية:</label>
        <input type="number" name="quantity" id="quantity" class="form-control quantity-input" value="1" min="1" required>
    </div>
    <input type="hidden" name="product_id" id="product_id" value="<?php echo $product_id; ?>">
    <button type="submit" class="btn btn-success">
        <i class="bi bi-cart-plus"></i> أضف إلى السلة
    </button>
</form>

<div id="add-message" class="mt-3 text-success"></div>

        </div>
    </div>
</div>

<!-- الفوتر -->
<div id="footer_p"></div>

<script>
    fetch("header.html")
        .then(res => res.ok ? res.text() : Promise.reject())
        .then(data => document.getElementById("navbar-placeholder").innerHTML = data);

    fetch("footer.html")
        .then(res => res.ok ? res.text() : Promise.reject())
        .then(data => document.getElementById("footer_p").innerHTML = data);


     
document.getElementById("add-to-cart-form").addEventListener("submit", function(e) {
    e.preventDefault(); // منع الانتقال
    
    const formData = new FormData(this);

    fetch("add_to_cart.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        document.getElementById("add-message").innerHTML = "✅ تم إضافة المنتج إلى السلة!";
    })
    .catch(() => {
        document.getElementById("add-message").innerHTML = "❌ حدث خطأ أثناء الإضافة.";
    });
});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
