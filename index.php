<?php
/* 
 * I am making use of .htaccess to redirect all requests to this file.
 * The idea is to make a mini simple router to the target actions in my controllers
 */

include 'vendor/autoload.php';

use App\Router;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use DevCoder\DotEnv;

$absolutePathToEnvFile = __DIR__ . '/.env';

(new DotEnv($absolutePathToEnvFile))->load();

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);
$method = $_SERVER['REQUEST_METHOD'];

$router = new Router($method, $uri);
$auth = new AuthController();
$dashboard = new DashboardController();




// if($method == 'GET' &&  $uri == '/'){

//     require_once 'templates/auth/login.php';

// } else if ($method == 'GET' &&  $uri == '/register'){

//     require_once 'templates/auth/register.php';

// } else if ($method == 'GET' &&  $uri == '/profile'){

//     require_once 'templates/profile.php';

// } else if ($method == 'POST' &&  $uri == '/profile'){

//     $_POST = json_decode(file_get_contents("php://input"),true);

//     $dashboard->updateProfile($_POST);

// } else if ($method == 'GET' &&  $uri == '/logout'){

//     $auth->logout();

// } else if ($method == 'POST' &&  $uri == '/users'){

//     $_POST = json_decode(file_get_contents("php://input"),true);
//     if($auth->check()){
//         return $dashboard->getAllUsers($_POST);
//     }else{
//         header('Location: /');
//     }

// }else if ($method == 'POST' &&  $uri == '/user'){

//     $_POST = json_decode(file_get_contents("php://input"),true);
//     if($auth->check()){
//         return $dashboard->getUser();
//     }else{
//         header('Location: /');
//     }

// }else if ($method == 'POST' &&  $uri == '/update-user'){

//     $_POST = json_decode(file_get_contents("php://input"),true);
//     if($auth->check()){
//         return $dashboard->updateUserProfile($_POST);
//     }else{
//         header('Location: /');
//     }

// } else if ($method == 'GET' &&  $uri == '/dashboard'){

//     if($auth->check()){
//         $dashboard->index();
//     }else{
//         header('Location: /');
//     }

// } else if ($method == 'POST' &&  $uri == '/login'){

//     if(!$auth->login($_POST)){
//         $invalid = true;
//         require_once 'templates/auth/login.php';
//     }

// } else if ($method == 'POST' &&  $uri == '/register'){

//     $auth->register($_POST);

// } else if ($method == 'GET' &&  $uri == '/password_reset'){

//     require_once 'templates/auth/reset.php';

// } else if ($method == 'POST' &&  $uri == '/password_reset'){

//     $auth->resetPassword($_SERVER['REQUEST']);

// } else {

//     require_once 'templates/404.php';
    
// }


