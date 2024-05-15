<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel
larastan:
---------
> ./vendor/bin/phpstan analyse --memory-limit=2G

phpstan.dist.neon: file
------------------
includes:
    - vendor/larastan/larastan/extension.neon

parameters:

    paths:
        - app/

    # Level 9 is the highest level
    level: 5

pint
-----
> ./vendor/bin/pint


Pulse:
-------
> composer require laravel/pulse
> php artisan vendor:publish --provider="Laravel\Pulse\PulseServiceProvider"
> php artisan migrate
> php artisan vendor:publish --tag=pulse-config
> php artisan vendor:publish --tag=pulse-dashboard

Redis:
------
> composer require predis/predis

//Queue_connection set as redis
//.env file
QUEUE_CONNECTION=redis

//Email Template
> php artisan make:mail SendTestMail --markdown=emails.testmail

//use web.php
Route::get('/', function () {
     \Mail::to('sharmila@cloudrevelinnovation.com')->send(new \App\Mail\SendTestMail());
     return view('welcome');
});

//Make Email Job
> php artisan make:job SendEmailJob

public function handle(): void
{
    \Mail::to('sharmiladevi@cloudrevelinnovation.com')->send(new \App\Mail\SendTestMail());
}
//use web.php
Route::get('/', function () {
     dispatch(new \App\Jobs\SendEmailJob());
     return view('welcome');
});

> php artisan queue:work --timeout=0

GUI for redis:
- - - -- -- -
npm install -g redis-commander
redis-commander

Bulk Upload CSV:
----------------
> php artisan make:model Employee -m
> php artisan make:controller EmployeeController --resource --requests --model=Employee
php.ini settings
memory_limit=1024m
post_max_size=300m
upload_max_file_size=200m
> php artisan migrate
> php artisan make:job ProcessCSV
> 