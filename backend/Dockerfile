FROM php:8.1-apache

# 安裝系統依賴
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    libicu-dev \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# 安裝 PHP 擴展
RUN docker-php-ext-install zip \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install pdo_mysql

# 啟用 Apache mod_rewrite
RUN a2enmod rewrite

# 設置工作目錄
WORKDIR /var/www/html

# 複製專案檔案
COPY . .

# 設置 Apache 配置
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

# 創建上傳目錄結構
RUN mkdir -p public/uploads/images/2024/12/18

# 設置權限
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/writable \
    && chmod -R 777 /var/www/html/public/uploads

# 啟用 Apache 配置
RUN a2ensite 000-default.conf