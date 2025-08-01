<?php 
if (!isset($_POST['status'])) {
    die("لم يتم تحديد الحالة.");
}
else{
    if($_POST['status'] == 'جاري التجهيز') {
    $status = 'تم التوصيل';
} elseif($_POST['status'] == 'جديد') {
    $status = 'جاري التجهيز';
}
}

   
$conn = new mysqli("localhost", "root", "", "productsdxn");
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}
$query = "UPDATE orders SET status = '$status' WHERE id_order = {$_POST['id']}";
$result = $conn->query($query);
if ($result) {
    header("Location: admin_order.php?status=$status");
    exit;
} else {
    echo "خطأ في تحديث الحالة: " . $conn->error;
}







?>

