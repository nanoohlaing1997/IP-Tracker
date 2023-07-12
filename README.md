<h1 align="center"> Tracking IP and User auth with token </h1>

### Requirement

- PHP (>= 8)
- Laravel (>= 10)
- Apache or Nginx
- Mysql Client
- Composer (>= 2)

## Setup guide

This guide is only for developers who want to Track IP from user authentication and authorization.

Clone this [repo](https://github.com/nanoohlaing1997/ip-tracker) with http

```
git clone https://github.com/nanoohlaing1997/ip-tracker
```

### Create Database

Go to mysql client
```
create database geo_location;
```

### Setup application

Pleas go to the path that you cloned

Copy `.env.example` to `.env`

```
cp .env.example .env
```

Install composer
```
composer install
```
Migrate database tables

(*note - please ensuring that your mysql server is connecting with your laravel application correctly. To troubleshoot, check .env config and app\config\database.php)
```
php artisan migrate
```
Start the application
```
php artisan serve
```
- you will see localhost:8000 is running


### API Documentation


