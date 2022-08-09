# Laravel-ToDoApp

# 環境

Laravel 8

MySQL 8.0

PHP 8.0

Redis

Apache 2.4

# 構築

コンテナ立ち上げ

```
$ docker-compose up -d --build
```
laravel初期化
```
$ docker-compose run --rm app bash

$cd app

$ cp .env.example .env

$ composer install

$ php artisan key:generate

$ php artisan migrate:fresh
```



## mysqlコンテナ
```
$ docker-compose exec db bash
```

## Laravelコンテナ
```
$ docker-compose run --rm app bash
```

# コンテナとボリュームを削除
```
$ docker-compose down --rmi all --volumes --remove-orphans
```