<?php
session_start();
$conn = new mysqli("localhost", "root", "", "productsdxn");
if ($conn->connect_error) die("فشل الاتصال: " . $conn->connect_error);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // استعلام التحقق
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
     
        $_SESSION['admin_logged_in'] = $username;
        header("Location: admin_order.php");
        exit();
    } else {
        
        $error = "اسم المستخدم أو كلمة المرور غير صحيحة.";
    }
    $stmt->close();
} else {
    // إذا لم يكن هناك طلب POST، نعيد تعيين الخطأ   
    $error = '';
}
$conn->close();

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل دخول الأدمن</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
</head>
<style>
    *{
        font-family: 'Cairo', sans-serif;
    }
</style>
<body class="bg-light">
<div class="container py-5">
    <div class="col-md-5 mx-auto bg-white p-4 shadow-sm rounded">
        <h3 class="mb-3 text-center">تسجيل دخول الأدمن</h3>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">اسم المستخدم</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">كلمة المرور</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100">تسجيل الدخول</button>
        </form>
    </div>
</div>
</body>
</html>
