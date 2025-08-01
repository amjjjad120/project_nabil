<?php
session_start();
$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    die("السلة فارغة.");
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تأكيد الطلب</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        *{
             font-family: 'Cairo', sans-serif;
        }
        body {
            background-color: #f0f2f5;
           
        }
        .checkout-card {
            background: #fff;
            border-radius: 18px;
            padding: 35px 40px;
            box-shadow: 0 6px 25px rgba(0,0,0,0.1);
        }
        .form-label i {
            color: #0d6efd;
            margin-left: 8px;
            font-size: 1.2rem;
        }
        .order-summary {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px 30px;
            box-shadow: inset 0 0 8px #d1d7de;
        }
        .list-group-item {
            background: transparent;
            border: none;
            padding: 12px 0;
            font-size: 1.05rem;
        }
        .list-group-item .item-name {
            font-weight: 600;
            color: #343a40;
        }
        .list-group-item .item-qty {
            font-weight: 500;
            color: #6c757d;
            margin: 0 12px;
        }
        .list-group-item .item-price {
            font-weight: 700;
            color: #0d6efd;
        }
        .total-row {
            border-top: 2px solid #0d6efd;
            font-size: 1.25rem;
            font-weight: 700;
            color: #0b5ed7;
            padding-top: 15px;
            margin-top: 15px;
        }
        h4 {
            border-bottom: 3px solid #0d6efd;
            padding-bottom: 10px;
            margin-bottom: 25px;
            font-weight: 700;
            color: #0d6efd;
        }
        button.btn-success {
            font-size: 1.2rem;
            padding: 12px 0;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<!-- الهيدر -->
<div id="navbar-placeholder"></div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="row g-5 checkout-card">
                <!-- نموذج بيانات العميل -->
                <div class="col-md-6">
                    <h4><i class="bi bi-person-lines-fill"></i> بيانات العميل</h4>
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger">يرجى تعبئة جميع الحقول المطلوبة.</div>
                    <?php endif; ?>
                    <form action="save_order.php" method="post" novalidate>
                        <div class="mb-4">
                            <label class="form-label"><i class="bi bi-person-circle"></i> الاسم الكامل</label>
                            <input type="text" name="name" class="form-control form-control-lg" placeholder="" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label"><i class="bi bi-whatsapp"></i> رقم الواتساب</label>
                            <input type="tel" name="whatsapp" class="form-control form-control-lg" placeholder="الرقم مع رمز الدولة" required>
                            <?php if (isset($_GET['errorwhatsapp'])): ?>
                                <div class="alert alert-danger">رقم الواتساب غير صالح.</div>
                            <?php endif; ?>
                        
                        </div>
                        <div class="mb-4">
                            <label class="form-label"><i class="bi bi-envelope"></i> البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control form-control-lg" placeholder="" required>
                            <?php if (isset($_GET['erroremail'])): ?>
                                <div class="alert alert-danger">البريد الإلكتروني غير صالح.</div>   
                            <?php endif; ?>
                        </div>
                        <div class="mb-4">
                            <label class="form-label"><i class="bi bi-globe"></i> الدولة</label>
                            <input type="text" name="country" class="form-control form-control-lg" placeholder=" اليمن" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label"><i class="bi bi-geo-alt"></i> المدينة</label>
                            <input type="text" name="city" class="form-control form-control-lg" placeholder=" تعز" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-check-circle"></i> إرسال الطلب
                        </button>
                    </form>
                </div>

                <!-- ملخص الطلب -->
                <div class="col-md-6 order-summary">
                    <h4><i class="bi bi-basket"></i> ملخص الطلب</h4>
                    <ul class="list-group list-group-flush">
                        <?php
                        $conn = new mysqli("localhost", "root", "", "productsdxn");
                        $total = 0;

                        foreach ($cart as $id => $qty) {
                            $res = $conn->query("SELECT name_pro, price FROM product WHERE id_pro = $id");
                            if ($row = $res->fetch_assoc()) {
                                $sum = $qty * $row['price'];
                                $total += $sum;
                                echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
                                        <span>
                                            <span class='item-name'>{$row['name_pro']}</span>
                                            <span class='item-qty'>× $qty</span>
                                        </span>
                                        <span class='item-price'>{$sum} ريال</span>
                                      </li>";
                            }
                        }
                        ?>
                        <li class="list-group-item total-row d-flex justify-content-between">
                            <span>الإجمالي</span>
                            <span><?php echo $total; ?> ريال</span>
                        </li>
                    </ul>
                </div>
            </div>
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
