# Dockerfile
FROM php:8.1-apache

# 安裝必要的 PHP 擴展
RUN docker-php-ext-install pdo pdo_mysql

# 啟用 Apache rewrite 模組
RUN a2enmod rewrite

# 設定 Apache DocumentRoot
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 建立上傳目錄
RUN mkdir -p /var/www/html/public/uploads && \
    chown -R www-data:www-data /var/www/html/public/uploads && \
    chmod -R 755 /var/www/html/public/uploads
    