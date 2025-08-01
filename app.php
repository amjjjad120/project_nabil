<?php
// إعدادات الاتصال بقاعدة البيانات
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'productsdxn';

// الاتصال بقاعدة البيانات
$conn = new mysqli($host, $user, $password, $database);

// التحقق من الاتصال
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// استعلام SQL لجلب الفئات وعدد المنتجات
$sql = "
    SELECT 
        cat.id,
        cat.name_cat,
        cat.img_cat,
        COUNT(product.id_pro) AS product_count
    FROM 
        cat
    LEFT JOIN 
        product ON product.id = cat.id
    GROUP BY 
        cat.id, cat.name_cat, cat.img_cat
";

// تنفيذ الاستعلام
$result = $conn->query($sql);

// معالجة النتائج
if ($result) {
    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }

    // إعادة النتيجة على شكل JSON

} else {
    http_response_code(500);
    echo json_encode(['error' => 'Query error']);
}

// إغلاق الاتصال
$conn->close();
?>
