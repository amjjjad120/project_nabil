
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// تحميل المكتبة
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = htmlspecialchars($_POST['name']);
    $email   = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        // إعدادات SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'amjjjad120@gmail.com';          // بريد Gmail الخاص بك
        $mail->Password   = 'njnr qake menl fcrg';             // كلمة مرور التطبيقات من Google
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // معلومات المرسل والمستقبل
        $mail->setFrom($email, $name);                       // من الزائر
        $mail->addAddress('amjjjad120@gmail.com');           // بريدك أنت

        // محتوى الرسالة
       $mail = new PHPMailer(true);

$mail->CharSet = "UTF-8";         // ✅ دعم اللغة العربية
$mail->isSMTP();
$mail->Host       = 'smtp.gmail.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'amjjjad120@gmail.com';
$mail->Password   = 'njnr qake menl fcrg';
$mail->SMTPSecure = 'tls';
$mail->Port       = 587;

$mail->setFrom($email, $name);
$mail->addAddress('amjjjad120@gmail.com');

$mail->isHTML(true);
$mail->Subject = "📩 رسالة جديدة من $name";
$mail->Body = "
    <div style='font-family:Tahoma, Arial; direction:rtl; text-align:right; padding:15px; border:1px solid #ddd; border-radius:8px;'>
        <h3 style='color:#0d6efd;'>📬 رسالة جديدة من نموذج التواصل</h3>
        <p><strong>الاسم:</strong> $name</p>
        <p><strong>البريد الإلكتروني:</strong> <a href='mailto:$email'>$email</a></p>
        <p><strong>الموضوع:</strong> $subject</p>
        <hr>
        <p><strong>نص الرسالة:</strong></p>
        <div style='background:#f8f9fa; padding:10px; border-radius:5px;'>".nl2br($message)."</div>
    </div>
";

           $mail->send();
        $statusMsg = "✅ تم إرسال الرسالة بنجاح!";
        $alertType = "success";
    } catch (Exception $e) {
        $statusMsg = "❌ فشل في الإرسال: {$mail->ErrorInfo}";
        $alertType = "danger";
    }
}
?>





<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سلايدر رئيسي</title>
    <!-- Bootstrap 5 RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" integrity="sha384-PiRHwN6Q0JzQ5J5gk5K8+5+5j5J5k5k5k5k5k5k5k5k5k5k5k5k5k5k5k5k5k5k5" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"> -->

    <style>

  /* الأساسيات */
  .social-icon {
    color: #ffffff;
    
    transition: color 0.3s ease, transform 0.3s ease;
  }

  /* عند المرور: تغيير لون الأيقونة فقط */
  .social-link.telegram:hover {
    color: #229ED9;
    transform: scale(1.1);
    padding: 10px;
    border-radius: 50px;
   
  }

  .social-link.facebook:hover {
    color: #1877f2;
    transform: scale(1.1);
      padding: 10px;
    border-radius: 50px;
  }

  .social-link.instagram:hover {
    color: #E1306C;
    transform: scale(1.1);
      padding: 10px;
    border-radius: 50px;
    
  }
  .social-link.whatsapp i:hover {
    color: #25D366;
    transform: scale(1.1);
      padding: 10px;
    border-radius: 50px;
  }
        *{
            font-family: 'Cairo', sans-serif;
        }

        .card-img {
            height: 300px;          /* ← تحديد الارتفاع */
            object-fit: cover; 
        
        }
        .about{
        margin-bottom:4% ;
  
        }
            .card .overlay {
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background-color: rgba(0, 0, 0, 0.6); 
        }
        .howwe{
        
        position: relative;
            z-index: 2;
            background: linear-gradient(to right, rgba(61, 120, 182, 1), rgba(179, 216, 255, 1));
            padding: 10px 150px;
          
            border-radius: 20px;
        }
        
        </style>
        
</head>
<body>
    <!-- مكان الشريط العلوي -->
    <div id="navbar-placeholder"></div>

    <div class="card text-bg-dark about">
        <img src="https://th.bing.com/th/id/OIP.NUlwNjPkWPWiDx6B-3ZjyQHaEu?r=0&o=7rm=3&rs=1&pid=ImgDetMain&o=7&rm=3" class="card-img" alt="...">
        <div class="overlay"></div>
        <div class="card-img-overlay d-flex justify-content-center align-items-center text-center">
          <div>
            <h5 class="card-title fs-1 howwe">التواصل </h5>
            <p class="card-text">
              <!-- هذا نص توضيحي أطول قليلاً، يدعم محتوى البطاقة ويظهر في منتصف الصورة. -->
            </p>
            <!-- <p class="card-text"><small>آخر تحديث قبل 3 دقائق</small></p> -->
          </div>
        </div>
      </div>
     
<div class="container my-5">
  <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4 bg-dark text-white p-4 rounded-4 " style="height: 30%;">

    <div class="col">
      <div class="d-flex align-items-center gap-3">
        <a href="https://t.me/yourchannel" target="_blank" class="text-white social-link telegram">
          <i class="fab fa-telegram-plane fs-1"></i>
        </a>
<a href="" class="text-decoration-none text-white"> <h5 class="mb-0">تيليجرام</h5>
</a>
      </div>
    </div>

    <div class="col">
      <div class="d-flex align-items-center gap-3">
        <a href="https://facebook.com/yourpage" target="_blank" class="text-white social-link facebook">
          <i class="fab fa-facebook-f fs-1"></i>
        </a>
      <a class="text-decoration-none text-white" href="">  <h5 class="mb-0">فيسبوك</h5></a>
      </div>
    </div>

    <div class="col">
      <div class="d-flex align-items-center gap-3">
        <a href="https://instagram.com/yourpage" target="_blank" class="text-white social-link instagram">
          <i class="fab fa-instagram fs-1"></i>
        </a>
        <a href="" class="text-decoration-none text-white"><h5 class="mb-0">انستجرام</h5></a>
      </div>
    </div>
    <div class="col">
      <div class="d-flex align-items-center gap-3">
        <a href="https://wa.me/yourwhatsappnumber" target="_blank" class="text-white social-link whatsapp">
          <i class="fab fa-whatsapp fs-1"></i>
        </a>
        <a href="https://wa.me/967712016614?text=مرحبا%20نبيل%20صالح%20الجعفري" class="text-decoration-none text-white"><h5 class="mb-0">واتساب</h5></a>
      </div>

   

 

  </div>
</div>



<!-- استدعاء Bootstrap CSS -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->

<div class="container my-5">
  <div class="card shadow-lg p-4 rounded-4">
    <h3 class="mb-4 text-center">خليك على تواصل معنا </h3>
    <div class="container mt-5">
    <?php if (!empty($statusMsg)): ?>
        <div class="alert alert-<?= $alertType ?> text-center">
            <?= $statusMsg ?>
        </div>
    <?php endif; ?>

      
    
</div>
<form method="post">
  <div class="mb-3">
    <input type="text" class="form-control" name="name" placeholder="ادخل اسمك" required>
  </div>

  <div class="mb-3">
    <input type="email" class="form-control text-end" name="email" placeholder="البريد الإلكتروني" required>
  </div>

  <div class="mb-3">
    <input type="text" class="form-control" name="subject" placeholder="الموضوع" required>
  </div>

  <div class="mb-3">
    <textarea class="form-control" name="message" rows="5" placeholder="اكتب رسالتك هنا..." required></textarea>
  </div>

  <div class="text-center">
    <button type="submit" class="btn btn-primary px-5 rounded-pill">إرسال</button>
  </div>
</form>

  </div>
</div>



    <!-- مكان الفوتر -->
    <div class=""  id="footer_p" style=" width:100%"  ></div>

    <script>
        // تحميل الهيدر مع معالجة الأخطاء
        fetch("header.html")
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.text();
            })
            .then(data => {
                document.getElementById("navbar-placeholder").innerHTML = data;
            })
            .catch(error => {
                console.error('Error loading header:', error);
                document.getElementById("navbar-placeholder").innerHTML = '<nav class="navbar bg-light"><div class="container"><a class="navbar-brand" href="#">الرئيسية</a></div></nav>';
            });

        // تحميل الفوتر مع معالجة الأخطاء
        fetch("footer.html")
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.text();
            })
            .then(data => {
                document.getElementById("footer_p").innerHTML = data;
            })
            .catch(error => {
                console.error('Error loading footer:', error);
                document.getElementById("footer_p").innerHTML = '<footer class="py-3 bg-light"><div class="container"><p class="text-center">© 2023 جميع الحقوق محفوظة</p></div></footer>';
            });
    </script>
    
    <!-- Bootstrap JS -->
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