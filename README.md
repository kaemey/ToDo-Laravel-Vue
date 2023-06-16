<h1 align="center">
  Todo листинг с асинхронными крудом,<br>поиском и фильтрами.
</h1>
<h2>Деплой на VPS (Ubuntu):</h2><br><br>
sudo apt update<br><br>
NGINX
sudo apt install nginx
sudo systemctl reload nginx

MYSQL
sudo apt install mysql-server

sudo mysql
SELECT user,authentication_string,plugin,host FROM mysql.user;

ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'password';

sudo mysql_secure_installation

CREATE USER 'username'@'host' IDENTIFIED WITH mysql_native_password BY 'password';

CREATE DATABASE Название БД;

GRANT ALL ON laravel.* TO 'laravel'@'localhost';

FLUSH PRIVILEGES;

PHP-FPM-8.2

sudo apt update && sudo apt install -y software-properties-common 
sudo add-apt-repository ppa:ondrej/php 
sudo apt update
sudo apt install php8.2-fpm

GIT
sudo apt install git

COMPOSER
cd ~
sudo php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer

NODE NPM
curl -fsSL https://deb.nodesource.com/setup_19.x | bash - &&\
sudo apt-get install -y nodejs

PHP Extensions
sudo apt-get install php-bcmath
sudo apt-get install php-mbstring
sudo apt-get install php-gd
sudo apt-get install php-zip
sudo apt-get install php-common
sudo apt-get install php-xml
sudo apt-get install php-curl
sudo apt-get install php-mysql
