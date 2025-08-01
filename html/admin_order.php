<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}




$conn = new mysqli("localhost", "root", "", "productsdxn");
if ($conn->connect_error) die("فشل الاتصال: " . $conn->connect_error);


$statusFilter = $_GET['status'] ?? '';
$filterQuery = $statusFilter ? "WHERE o.status = '$statusFilter'" : "";


$query = "SELECT o.id_order, o.customer_name, o.whatsapp, o.country, o.city, o.order_date, o.status,
                p.name_pro, p.img_pro, i.quantity, i.price, i.total
          FROM orders o
          JOIN order_items i ON o.id_order = i.id_order
          JOIN product p ON i.id_pro = p.id_pro
          $filterQuery
          ORDER BY o.order_date DESC";

$result = $conn->query($query);


$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[$row['id_order']]['info'] = [
        'customer_name' => $row['customer_name'],
        'whatsapp' => $row['whatsapp'],
        'country' => $row['country'],
        'city' => $row['city'],
        'order_date' => $row['order_date'],
        'status' => $row['status']
    ];
    $orders[$row['id_order']]['items'][] = [
        'name_pro' => $row['name_pro'],
        'img_pro' => $row['img_pro'],
        'quantity' => $row['quantity'],
        'price' => $row['price'],
        'total' => $row['total']
    ];
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة تحكم الطلبات</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <style>
      * {
            font-family: 'Cairo', sans-serif;
        }
        .order-card {
            border: 1px solid #ccc;
            margin-bottom: 30px;
            border-radius: 10px;
            padding: 20px;
        }
        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
        th{
            background: linear-gradient(rgba(61,128,182,1),rgba(100,128,182,1));
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

<!-- Bootstrap JS -->



<div class="container py-5" style="margin-top:100px">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow mb-4">
        <div class="card-body">
          <div class="d-flex align-items-center mb-3">
            <h2 class="mb-0 flex-grow-1">لوحة الطلبات</h2>
            <span class="badge bg-primary fs-5 ms-2">مرحبا، <?php echo $_SESSION['admin_logged_in']; ?></span>
          </div>
          <div class="row text-center">
            <div class="col-md-3 mb-2">
              <div class="card border-0 bg-light h-100">
                <div class="card-body">
                  <div class="fs-4 fw-bold text-dark"><?= count($orders) ?></div>
                  <div class="text-muted">إجمالي الطلبات</div>
                </div>
              </div>
            </div>
            <div class="col-md-3 mb-2">
              <div class="card border-0 bg-info bg-opacity-25 h-100">
                <div class="card-body">
                  <div class="fs-4 fw-bold text-info"><?= count(array_filter($orders, fn($order) => $order['info']['status'] === 'جديد')) ?></div>
                  <div class="text-muted">الطلبات الجديدة</div>
                </div>
              </div>
            </div>
            <div class="col-md-3 mb-2">
              <div class="card border-0 bg-warning bg-opacity-25 h-100">
                <div class="card-body">
                  <div class="fs-4 fw-bold text-warning"><?= count(array_filter($orders, fn($order) => $order['info']['status'] === 'جاري التجهيز')) ?></div>
                  <div class="text-muted">جاري التجهيز</div>
                </div>
              </div>
            </div>
            <div class="col-md-3 mb-2">
              <div class="card border-0 bg-success bg-opacity-25 h-100">
                <div class="card-body">
                  <div class="fs-4 fw-bold text-success"><?= count(array_filter($orders, fn($order) => $order['info']['status'] === 'تم التوصيل')) ?></div>
                  <div class="text-muted">تم التوصيل</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


  
    <form method="get" class="mb-4">
        <div class="row g-2 align-items-center">
            <div class="col-md-4">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">كل الطلبات</option>
                    <option value="جديد" <?= $statusFilter === 'جديد' ? 'selected' : '' ?>>جديد</option>
                    <option value="جاري التجهيز" <?= $statusFilter === 'جاري التجهيز' ? 'selected' : '' ?>>جاري التجهيز</option>
                    <option value="تم التوصيل" <?= $statusFilter === 'تم التوصيل' ? 'selected' : '' ?>>تم التوصيل</option>
                </select>
            </div>
        </div>
    </form>

    <?php if (empty($orders)): ?>
        <div class="alert alert-info">لا توجد طلبات لعرضها.</div>
    <?php endif; ?>

    <?php foreach ($orders as $id => $order): ?>
        <div class="order-card bg-white shadow-sm">
            <h5>رقم الطلب: <?= $id ?> - <?= htmlspecialchars($order['info']['customer_name']) ?></h5>
            <p>
                <strong>الواتساب:</strong> <?= $order['info']['whatsapp'] ?> | 
                <strong>الدولة:</strong> <?= $order['info']['country'] ?> - <?= $order['info']['city'] ?> | 
                <strong>التاريخ:</strong> <?= $order['info']['order_date'] ?> | 
                <strong>الحالة:</strong> <span class="badge <?php if($order['info']['status']=='جديد'){echo"bg-primary";} elseif($order['info']['status']=='جاري التجهيز'){echo "bg-info";} else{echo "bg-success";}  ?>"><?= $order['info']['status'] ?></span>
            </p>

            <table class="table table-sm table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>الصورة</th>
                        <th>المنتج</th>
                        <th>الكمية</th>
                        <th>السعر</th>
                        <th>الإجمالي</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order['items'] as $item): ?>
                        <tr>
                            <td><img src="../<?= $item['img_pro'] ?>" class="product-img"></td>
                            <td><?= htmlspecialchars($item['name_pro']) ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= $item['price'] ?> ريال</td>
                            <td><?= $item['total'] ?> ريال</td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4" class="text-end"><strong>المجموع الكلي:</strong></td>
                        <td>
                            <?php
                            $total = array_sum(array_column($order['items'], 'total'));
                            echo $total . " ريال";
                            ?>
                        </td> </tr>
                        <tr>
                            <td>
                            <form  action="update_order_status.php" method="post">                           
                            <input type="text" name="id" value="<?=$id?>" class="d-none">
                            <input type="text" name="status" value="<?php echo $order['info']['status']; ?>" class="d-none">
<button  type="submit" class="btn btn-info  <?php if($order['info']['status']=='جاري التجهيز' || $order['info']['status']=='تم التوصيل'){echo"d-none";} ?>">تجهيز الطلب</button>
                            </form>
                            <form  action="update_order_status.php" method="post">
                                <input type="text" name="id" value="<?=$id?>" class="d-none">
                                <input type="text" name="status" value="<?php echo $order['info']['status']; ?>" class="d-none">
                            <button type="submit" class="btn btn-primary <?php if($order['info']['status']=='جديد' || $order['info']['status']=='تم التوصيل'){echo"d-none";} ?>">تم التوصيل </button>
                        </td>
                            </form>

                        </tr>
                    


                </tbody>
            </table>
        </div>
    <?php endforeach; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
