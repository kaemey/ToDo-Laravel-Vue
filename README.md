<h1 align="center"> Todo листинг с асинхронными крудом,
    <br>поиском и фильтрами. </h1> 
    <h2>Деплой на VPS (Ubuntu):</h2> 
    sudo apt update<br><br> 
    NGINX sudo apt install nginx sudo systemctl reload nginx<br><br> 
    MYSQL<br> 
    sudo apt install mysql-server<br><br> 
    sudo mysql<br>
    SELECT user,authentication_string,plugin,host FROM mysql.user;<br> 
    ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'password';<br> 
    sudo mysql_secure_installation<br> 
    CREATE USER 'username'@'host' IDENTIFIED WITH mysql_native_password BY 'password';<br> 
    CREATE DATABASE Название БД;<br><br>
    GRANT ALL ON laravel.* TO 'laravel'@'localhost';<br>
    FLUSH PRIVILEGES;<br><br> 
    PHP-FPM-8.2<br> 
    sudo apt update && sudo apt install -y software-properties-common<br> 
    sudo add-apt-repository ppa:ondrej/php<br> 
    sudo apt update sudo apt install php8.2-fpm<br><br> 
    GIT<br>
    sudo apt install git<br><br> 
    COMPOSER cd ~ sudo php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer<br><br> 
    NODE NPM <br>
    curl -fsSL https://deb.nodesource.com/setup_19.x | bash - &&\ <br> 
    sudo apt-get install -y nodejs<br><br> 
    PHP Extensions:<br> 
    sudo apt-get install php-bcmath<br> 
    sudo apt-get install php-mbstring<br> 
    sudo apt-get install php-gd<br> 
    sudo apt-get install php-zip<br> 
    sudo apt-get install php-common<br> 
    sudo apt-get install php-xml<br> 
    sudo apt-get install php-curl<br> 
    sudo apt-get install php-mysql
