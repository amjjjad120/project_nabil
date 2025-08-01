FROM php:8.2-apache

# نسخ الملفات من مجلد html إلى مجلد Apache
COPY html/ /var/www/html/

# نسخ مجلد الصور إلى نفس المكان (لو خارج html)
COPY img/ /var/www/html/

# تفعيل mod_rewrite (إذا بتستخدم .htaccess أو روابط ديناميكية)
RUN a2enmod rewrite

# صلاحيات اختيارية
RUN chown -R www-data:www-data /var/www/html
