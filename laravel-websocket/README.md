### Auto config
```
composer install
php artisan migrate
php artisan db:seed
```


## Step by step configuration
- configuration websocket
- create pusher channel
```
composer require pusher/pusher-php-server
```
**Websocket config**
```
'useTLS' => true,
'encrypted' => true,
'host' => '127.0.0.1',
'port' => 6001,
'scheme' => 'http'
```
**Running websocket**
after running laraver serve, create new session terminal and type the command below
```
php artisan websockets:serve
```
open in web browser
http://localhost:8000/laravel-websockets
and connect to websockets port
