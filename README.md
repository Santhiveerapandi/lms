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

Api:
---
> php artisan install:api

> composer require php-open-source-saver/jwt-auth

> php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"

> php artisan jwt:secret

### app/Http/Controllers/Api/ApiController.php

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;

class ApiController extends Controller
{
    //Register Method - POST (name, email, password)
    public function register(Request $request)
    {
        // Validation
        /* $request->validate([
            "name" => "required|string",
            "email" => "required|string|email|unique:users",
            "password" => "required|confirmed" // password_confirmation
        ]); */
        $validator = Validator::make($request->all(), [
            'name' => 'required|between:2,100',
            'email' => 'required|email|unique:users|max:50',
            'password' => 'required|confirmed|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        // User model to save user in database
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password)
        ]);

        return response()->json([
            "status" => true,
            "message" => "User registered successfully",
            "data" => $user
        ]);
    }

    // Login API - POST (email, password)
    public function login(Request $request){

        // Validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        $token = auth('api')->attempt([
            "email" => $request->email,
            "password" => $request->password
        ]);

        if(!$token){

            return response()->json([
                "status" => false,
                "message" => "Invalid login details"
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => "User logged in succcessfully",
            "token" => $token,
            "expires_in" => auth('api')->factory()->getTTL() * 60
        ]);

    }

    // Profile API - GET (JWT Auth Token)
    public function profile(){

        //$userData = auth()->user();
        $userData = request()->user();

        return response()->json([
            "status" => true,
            "message" => "Profile data",
            "data" => $userData,
            //"user_id" => request()->user()->id,
            //"email" => request()->user()->email
        ]);
    }

    // Refresh Token API - GET (JWT Auth Token)
    public function refreshToken(){

        $token = auth()->refresh();

        return response()->json([
            "status" => true,
            "message" => "New access token",
            "token" => $token,
            "expires_in" => auth('api')->factory()->getTTL() * 60
        ]);
    }

    // Logout API - GET (JWT Auth Token)
    public function logout(){

        auth('api')->logout();

        return response()->json([
            "status" => true,
            "message" => "User logged out successfully"
        ]);
    }
}

routes/api.php:
--------------
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Route;

Route::post('register', [ApiController::class, 'register']);
Route::post('login', [ApiController::class, 'login']);

Route::group([
    'middleware' => ['auth:api'],
], function () {

    Route::get('profile', [ApiController::class, 'profile']);
    Route::get('refresh', [ApiController::class, 'refreshToken']);
    Route::get('logout', [ApiController::class, 'logout']);
});