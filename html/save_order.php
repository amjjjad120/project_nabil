<?php
session_start();
$conn = new mysqli("localhost", "root", "", "productsdxn");

if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// تحقق من أن السلة ليست فارغة
$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    die("السلة فارغة ولا يمكن تنفيذ الطلب.");
}

// استقبال البيانات من النموذج
$name = $_POST['name'] ?? '';
$whatsapp = $_POST['whatsapp'] ?? '';
$email = $_POST['email'] ?? '';
$country = $_POST['country'] ?? '';
$city = $_POST['city'] ?? '';

// تحقق من البيانات
if (empty($name) || empty($whatsapp) || empty($country) || empty($city)) {
    // die("يرجى تعبئة جميع الحقول المطلوبة.");
    header("Location: checkout.php?error=1");
    exit();
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // die("البريد الإلكتروني غير صالح.");
    header("Location: checkout.php?erroremail=1");
    exit();
}
if (!preg_match('/^\+?[0-9]{10,15}$/', $whatsapp)) {
    // die("رقم الواتساب غير صالح.");
    header("Location: checkout.php?errorwhatsapp=1");
    exit();
}

// إدخال الطلب في جدول الطلبات
$stmt = $conn->prepare("INSERT INTO orders (customer_name, whatsapp, email, country, city, order_date) VALUES (?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("sssss", $name, $whatsapp, $email, $country, $city);
$stmt->execute();

$order_id = $conn->insert_id; // رقم الطلب الجديد

// إدخال تفاصيل كل منتج في جدول order_items
foreach ($cart as $product_id => $qty) {
    $res = $conn->query("SELECT price FROM product WHERE id_pro = $product_id");
    if ($row = $res->fetch_assoc()) {
        $price = $row['price'];
        $total = $qty * $price;

        $stmt_item = $conn->prepare("INSERT INTO order_items (id_order, id_pro, quantity, price, total) VALUES (?, ?, ?, ?, ?)");
        $stmt_item->bind_param("iiidd", $order_id, $product_id, $qty, $price, $total);
        $stmt_item->execute();
    }
}

// مسح السلة
unset($_SESSION['cart']);

// إعادة التوجيه لصفحة نجاح
header("Location:view_cart.php?success=1");
exit;
?>
