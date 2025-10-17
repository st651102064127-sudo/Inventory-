# ใช้ PHP พร้อม Apache
FROM php:8.2-apache

# ติดตั้ง mysqli เพื่อให้ PHP เชื่อมต่อ MySQL ได้
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# เปิด mod_rewrite สำหรับ Laravel หรือ PHP ปกติ
RUN a2enmod rewrite

# กำหนด document root ให้เป็นโฟลเดอร์หลัก
WORKDIR /var/www/html

# ให้ Apache รันอยู่ foreground
CMD ["apache2-foreground"]
