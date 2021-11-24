<?php
/* 
 * I am making use of .htaccess to redirect all requests to this file.
 * The idea is to make a mini simple router to the target actions in my controllers
 */

include 'vendor/autoload.php';

use App\Router;
use DevCoder\DotEnv;

// Load the env file and make the variable available with the get_env() function
$absolutePathToEnvFile = __DIR__ . '/.env';
(new DotEnv($absolutePathToEnvFile))->load();

// Necessary request information for proper routing
$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);
$method = $_SERVER['REQUEST_METHOD'];

$router = new Router($method, $uri, $_REQUEST);

$router::get('/','App\Controllers\AuthController', 'index');
$router::get('/register','App\Controllers\AuthController', 'registerIndex');
$router::post('/register','App\Controllers\AuthController', 'register');
$router::post('/login','App\Controllers\AuthController', 'login');
$router::get('/dashboard','App\Controllers\DashboardController', 'index');
$router::post('/users','App\Controllers\DashboardController', 'getAllUsers');
$router::get('/profile','App\Controllers\DashboardController', 'profileIndex');
$router::post('/profile','App\Controllers\DashboardController', 'updateUserProfile');
$router::post('/user','App\Controllers\DashboardController', 'getUser');
$router::post('/update-user','App\Controllers\DashboardController', 'updateUserProfile');
$router::get('/password_reset','App\Controllers\AuthController', 'resetIndex');
$router::post('/password_reset','App\Controllers\AuthController', 'resetPassword');
$router::post('/password_reset_code','App\Controllers\AuthController', 'verifyPasswordResetCode');
$router::post('/password_reset_email','App\Controllers\AuthController', 'sendResetEmail');

$router::get('/logout','App\Controllers\AuthController', 'logout');

