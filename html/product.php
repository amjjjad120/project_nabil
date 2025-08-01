<?php
session_start();
  if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
  }
  



$conn = new mysqli("localhost", "root", "", "productsdxn");
if ($conn->connect_error) die("فشل الاتصال: " . $conn->connect_error);

// جلب الفئات
$categories = $conn->query("SELECT * FROM categories")->fetch_all(MYSQLI_ASSOC);

// إضافة / تعديل
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name_pro'];
    $des_pro = $_POST['des_pro'] ;
    $price = $_POST['price'];
    $id_cat = $_POST['id'];
    $id_pro = $_POST['id_pro'] ?? null;

    // رفع صورة
    if (!empty($_FILES['img_pro']['name'])) {
        $imgName = time() . '_' . $_FILES['img_pro']['name'];
        move_uploaded_file($_FILES['img_pro']['tmp_name'], "../$imgName");
        $imgPath = "$imgName";
    } else {
        $imgPath = $_POST['old_img'] ?? '';
    }

    if ($id_pro) {
        // تحديث
        $stmt = $conn->prepare("UPDATE product SET name_pro=?,des_pro=?, price=?, img_pro=?, id=? WHERE id_pro=?");
        $stmt->bind_param("ssdsii", $name,$des_pro, $price, $imgPath, $id_cat, $id_pro);
    } else {
        // إضافة
        $stmt = $conn->prepare("INSERT INTO product (name_pro,des_pro, price, img_pro, id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsi", $name,$des_pro, $price, $imgPath, $id_cat);
    }

    $stmt->execute();
    header("Location: product.php");
    exit;
}

// حذف منتج
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM product WHERE id_pro = $id");
    header("Location: product.php");
    exit;
}

// تعديل
$editProduct = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editProduct = $conn->query("SELECT * FROM product WHERE id_pro = $id")->fetch_assoc();
}

// جلب المنتجات مع الفئة
$products = $conn->query("
    SELECT p.*, c.name_cat 
    FROM product p 
    LEFT JOIN categories c ON p.id = c.id 
    ORDER BY p.id_pro DESC
")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة المنتجات</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
      *{
         font-family: 'Cairo', sans-serif;
      }
          .navbar-logo {
      height: 80px;
    }
    .navbar {
      background-color: rgba(0, 0, 0, 0.8);
    }
    .nav-link{
     color: white;
     font-size: 25px;
     margin-left: 20px;

    }
    </style>
</head>
<body class="bg-light">


<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><img src="../nabil.png" alt="Nabil" class="navbar-logo"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
      aria-controls="navbarContent" aria-expanded="false" aria-label="تبديل التنقل">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a id="home" class="nav-link" aria-current="page" href="home.html">الرئيسية</a>
        </li>
        <li class="nav-item">
          <a id="about" class="nav-link" href="about.html">حول</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="categories.php">المنتجات</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="product.php">ادارة المنتجات</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin_order.php">الطلبات </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="communication.php">اتصل بنا</a>
        </li>
      </ul>
      <div class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="بحث" aria-label="بحث">
        <button class="btn "style="background: linear-gradient(to right, rgba(61, 120, 182, 1), rgba(179, 216, 255, 1))" type="button">بحث</button>
        
        <!-- زر السلة -->
        <a href="view_cart.php" class="btn btn-outline-light ms-2 position-relative">
          <i class="bi bi-cart3"></i>
        </a>
      </div>
    </div>
  </div>
</nav>


<div class="container py-5" style="margin-top:100px">

    <?php
      $isEdit = isset($editProduct) && $editProduct;
      $formTitle = $isEdit ? 'تعديل المنتج' : 'إضافة منتج جديد';
      $formColor = $isEdit ? 'border-warning' : 'border-success';
      $formIcon = $isEdit ? '✏️' : '➕';
    ?>
    <div class="row justify-content-center">
      <div class="col-lg-10 col-xl-8">
        <div class="card shadow-sm mb-4 <?= $formColor ?>">
          <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0 <?= $isEdit ? 'text-warning' : 'text-success' ?>">
              <?= $formIcon ?> <?= $formTitle ?>
            </h4>
            <?php if ($isEdit): ?>
              <a href="product.php" class="btn btn-outline-success"><i class="bi bi-plus-circle"></i> إضافة منتج جديد</a>
            <?php endif; ?>
          </div>
          <div class="card-body">
            <form method="post" enctype="multipart/form-data" class="row g-3">
              <input type="hidden" name="id_pro" value="<?= $editProduct['id_pro'] ?? '' ?>">
              <input type="hidden" name="old_img" value="<?= $editProduct['img_pro'] ?? '' ?>">

              <div class="col-md-4">
                  <label class="form-label">اسم المنتج</label>
                  <input type="text" name="name_pro" class="form-control" required value="<?= $editProduct['name_pro'] ?? '' ?>">
              </div>
              <div class="col-md-3">
                  <label class="form-label">الوصف</label>
                  <textarea name="des_pro" class="form-control"><?= $editProduct['des_pro'] ?? '' ?></textarea>
              </div>

              <div class="col-md-2">
                  <label class="form-label">السعر</label>
                  <input type="number" step="0.01" name="price" class="form-control" required value="<?= $editProduct['price'] ?? '' ?>">
              </div>

              <div class="col-md-3">
                  <label class="form-label">الفئة</label>
                  <select name="id" class="form-select" required>
                      <option value="">اختر فئة</option>
                      <?php foreach ($categories as $cat): ?>
                          <option value="<?= $cat['id'] ?>" <?= ($editProduct['id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                              <?= htmlspecialchars($cat['name_cat']) ?>
                          </option>
                      <?php endforeach; ?>
                  </select>
              </div>

              <div class="col-md-3">
                  <label class="form-label">الصورة</label>
                  <input type="file" name="img_pro" class="form-control">
                  <?php if (!empty($editProduct['img_pro'])): ?>
                      <img src="<?php echo "../".$editProduct['img_pro']; ?>" width="50" class="mt-2 rounded">
                  <?php endif; ?>
              </div>

              <div class="col-12">
                <div class="d-flex justify-content-end">
                  <button type="submit" class="btn btn-success px-4 py-2">
                    <?php if ($isEdit) { echo '<i class="bi bi-pencil-square"></i> تعديل'; } else { echo '<i class="bi bi-plus-circle"></i> إضافة'; } ?>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <table class="table table-bordered bg-white shadow-sm text-center">
        <thead class="table-light">
            <tr>
                <th>الصورة</th>
                <th>الاسم</th>
                <th>الوصف</th>
                <th>السعر</th>
                <th>الفئة</th>
                <th>التحكم</th>
            
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $pro): ?>
                <tr>
                    <td><img src="<?php echo "../".$pro['img_pro']; ?>" width="50" class="rounded"></td>
                    <td><?= htmlspecialchars($pro['name_pro']) ?></td>
                    <td><?= htmlspecialchars($pro['des_pro'] ?? 'لا يوجد وصف') ?></td>
                    <td><?= $pro['price'] ?> ريال</td>
                    <td><?= htmlspecialchars($pro['name_cat']) ?></td>
                    <td>
                        <a href="?edit=<?= $pro['id_pro'] ?>" class="btn btn-sm btn-warning m-4">✏️ تعديل</a>
                        <a href="?delete=<?= $pro['id_pro'] ?>" onclick="return confirm('هل أنت متأكد من الحذف؟')" class="btn btn-sm btn-danger">🗑️ حذف</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
