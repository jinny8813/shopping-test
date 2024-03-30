# 使用 webdevops/php-nginx-dev:8.1 作為基礎映像檔
FROM webdevops/php-nginx-dev:8.1

# 設定工作目錄為 /app
WORKDIR /backend

# 設定環境變數
ENV WEB_DOCUMENT_ROOT=/backend/public \
    PHP_MEMORY_LIMIT=512M \
    PHP_MAX_EXECUTION_TIME=30 \
    PHP_POST_MAX_SIZE=20M \
    PHP_UPLOAD_MAX_FILESIZE=20M

# 複製應用程式代碼到容器
COPY ./backend /backend
COPY ./backend/env /backend/env

# 指定容器啟動時執行的命令（如果有）
# 例如，如果您需要在啟動時執行特定的腳本，可以在這裡添加
# CMD [ "php", "some-script.php" ]
