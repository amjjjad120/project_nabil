<?php
session_start();
$conn = new mysqli("localhost", "root", "", "productsdxn");

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$succe = isset($_GET['success']) ? intval($_GET['success']) : 0;

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>سلة المشتريات</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * {
            font-family: 'Cairo', sans-serif;
        }
        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<!-- الهيدر -->
<div id="navbar-placeholder"></div>

<div class="container" style="margin-top: 110px;">
    <h2 class="mb-4">🛒 سلة المشتريات</h2>

    <?php
    if ($succe) {
        echo '<div class="alert alert-success">تم تأكيد الطلب بنجاح!</div>';
    }
    if (empty($cart)) : ?>
        <p class="text-center">السلة فارغة.</p>
    <?php
else: ?>
        <table class="table table-bordered text-center">
            <thead class="table-light">
                <tr>
                    <th>الصورة</th>
                    <th>المنتج</th>
                    <th>الكمية</th>
                    <th>السعر</th>
                    <th>المجموع</th>
                    <th>حذف</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($cart as $id => $qty) {
                    $stmt = $conn->query("SELECT name_pro, price, img_pro FROM product WHERE id_pro = $id");
                    if ($stmt && $stmt->num_rows > 0) {
                        $row = $stmt->fetch_assoc();
                        $name = $row['name_pro'];
                        $price = $row['price'];
                        $img = $row['img_pro'];
                        $sum = $price * $qty;
                        $total += $sum;
                        echo "<tr>
                            <td><img src='../$img' class='product-img' alt='$name'></td>
                            <td>$name</td>
                            <td>
                                <div class='d-flex justify-content-center align-items-center gap-1'>
                                    <button class='btn btn-sm btn-outline-secondary' onclick='updateQuantity($id, \"decrease\")'>-</button>
                                    <span id='qty-$id' class='px-2'>$qty</span>
                                    <button class='btn btn-sm btn-outline-secondary' onclick='updateQuantity($id, \"increase\")'>+</button>
                                </div>
                            </td>
                            <td>$price ريال</td>
                            <td>$sum ريال</td>
                            <td>
                                <form method='post' action='remove_from_cart.php' onsubmit='return confirm(\"هل أنت متأكد من حذف المنتج؟\");'>
                                    <input type='hidden' name='product_id' value='$id'>
                                    <button type='submit' class='btn btn-danger btn-sm'>
                                        <i class='bi bi-trash'></i> حذف
                                    </button>
                                </form>
                            </td>
                        </tr>";
                    }
                }
                ?>
                <tr class="fw-bold table-success">
                    <td colspan="4">الإجمالي</td>
                    <td><?php echo $total; ?> ريال</td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <div class="text-end my-4">
            <form action="checkout.php" method="post">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-check2-circle"></i> تأكيد الطلب
                </button>
            </form>
        </div>
    <?php endif; ?>
</div>

<!-- الفوتر -->
<div id="footer_p"></div>

<script>
function updateQuantity(productId, action) {
    const formData = new FormData();
    formData.append("product_id", productId);
    formData.append("action", action);

    fetch("update_quantity.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById("qty-" + productId).textContent = data.newQty;
            location.reload(); // لتحديث السعر والإجمالي
        }
    });
}
</script>

<script>
    fetch("header.html")
        .then(res => res.ok ? res.text() : Promise.reject())
        .then(data => document.getElementById("navbar-placeholder").innerHTML = data);

    fetch("footer.html")
        .then(res => res.ok ? res.text() : Promise.reject())
        .then(data => document.getElementById("footer_p").innerHTML = data);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
