### Termux Webdev Fullstack
**Install termux apk**
<a href="https://f-droid.org/en/packages/com.termux/">Termux apk</a>

## Web server
**Apache webserver**
```bash
pkg install git -y &&
cd ~/ &&
git clone https://github.com/gungunpriatna/termux-php-apache2-setup.git &&
cd ~/termux-php-apache2-setup &&
bash setup &&
cd ~/ &&
rm -rf termux-php-apache2-setup
```
***Choose Y***
```
Do you want to continue? [Y/n]
```

Aftet success installation :
```
PHP and Apache2 Installed Sucessfully...
/sdcard/htdocs - is your document directory..
Place your files in /sdcard/htdocs
Run apachectl
```
***Check php version***
```
php -v
```
test for php in apache webserver htdocs :
```bash
echo "<?php phpinfo();?>" > storage/shared/htdocs/index.php
```
Running apache :
```bash
apachectl
```


## Mysql or MariaDB
Check updated termux :

```bash
apt update && apt upgrade
```
***Installation mariadb***

```bash
pkg install mariadb
```
Do you want to continue?[Y/n], choose (Y)

***Running mariadb first***
```
mysqld_safe -u root &
```
testing login to mariadb cli :
```
mysql -u $(whoami)
```
update your sql user authentication :
```
use mysql;
set password for 'root'@'localhost' = password('1');
flush privileges;
quit;
```
testing login to user root after update user db sql :
```
mysql -u root -p
#type your root password
```

#### Stoping mysql service
```
ps aux | grep mysql
mysqladmin shutdown

#check status again
ps aux | grep mysql
```

## Installing phpmyadmin
prepare :
```
pkg install wget

cd /sdcard/htdocs/

wget https://files.phpmyadmin.net/phpMyAdmin/5.1.2/phpMyAdmin-5.1.2-english.zip

unzip phpMyAdmin-5.1.2-english.zip

mv phpMyAdmin-5.1.2-english phpmyadmin
```

###Configuration phpmyadmin
```
cd phpmyadmin

nano config.sample.inc.php
```
***Search the script like &amp; replacing with this***
```
$cfg['Servers'][$i]['host'] = '127.0.0.1';
mv config.sample.inc.php config.inc.php
```

Testing in webserver :
```
apachectl

#Starting mysql again
mysqld_safe -u root &
```

***Access in web browser :***
```
localhost:8081

#Login with user root mariadb
username: root
password: 1
```
