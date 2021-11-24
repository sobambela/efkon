<?php

namespace App\Controllers;

use App\DB;
use App\Controllers\AuthController;

class DashboardController extends DB
{
    protected $auth;

    /**
     * Routes the URI of the GET method to the specified controller.
     *
     * @param  string  $route The user specified route, as it appears in the Request URI
     * @param  string  $targetControllerPath The fully qualified namespace path to the target controller
     * @param  string  $controllerMethod The method that will be called in the target controller
     * @return mix
     */
    public function __construct()
    {
        parent::__construct();
        $auth = new AuthController;
        $this->auth = $auth->check();
    }

    /**
     * Routes the URI of the GET method to the specified controller.
     */
    public function index(){
        if($this->auth){
            require_once 'templates/dashboard.php';
        }else{
            header('Location: /');
        }
    }

    /**
     * Routes the URI of the GET method to the specified controller.
     */
    public function profileIndex(){
        if($this->auth){
            require_once 'templates/profile.php';
        }else{
            header('Location: /');
        }
    }


    /**
     * Routes the URI of the GET method to the specified controller.
     *
     * @param  string  $route The user specified route, as it appears in the Request URI
     * @param  string  $targetControllerPath The fully qualified namespace path to the target controller
     * @param  string  $controllerMethod The method that will be called in the target controller
     * @return mix
     */
    public function getAllUsers($request){
        $sort = $request['sort'];
        echo json_encode($this->getUsers($sort));
        die();
    }

    /**
     * Routes the URI of the GET method to the specified controller.
     *
     * @param  string  $route The user specified route, as it appears in the Request URI
     * @param  string  $targetControllerPath The fully qualified namespace path to the target controller
     * @param  string  $controllerMethod The method that will be called in the target controller
     * @return mix
     */
    public function getUser(){
        session_start();
        $id = $_SESSION['user_id'];

        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        echo json_encode($user);
        die();
    }
    
    /**
     * Routes the URI of the GET method to the specified controller.
     *
     * @param  string  $route The user specified route, as it appears in the Request URI
     * @param  string  $targetControllerPath The fully qualified namespace path to the target controller
     * @param  string  $controllerMethod The method that will be called in the target controller
     * @return mix
     */
    public function updateUserProfile(array $request){
        $user = $this->updateUser($request);
        echo json_encode($user);
        die();
    }
}