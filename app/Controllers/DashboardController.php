<?php

namespace App\Controllers;

use App\DB;
use App\Controllers\AuthController;

class DashboardController extends DB
{
    protected $auth;

    /**
     * Boots the parent DB class so that the connection is made 
     * and creates an instance of auth controller to check Authentication.
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
     * Displays the relevant template
     * Redirects to login if the user is not authenticated.
     */
    public function index(){
        if($this->auth){
            require_once 'templates/dashboard.php';
        }else{
            header('Location: /');
        }
    }

    /**
     * Displays the relevant template
     * Redirects to login if the user is not authenticated.
     */
    public function profileIndex(){
        if($this->auth){
            require_once 'templates/profile.php';
        }else{
            header('Location: /');
        }
    }

    /**
     * Responds to the ajax request for all users
     *
     * @param  array  $request The request data with the sort order
     * @return string
     */
    public function getAllUsers(array $request){
        $sort = $request['sort'];
        echo json_encode($this->getUsers($sort));
        die();
    }

    /**
     * Responds to the ajax request for to get the logged in user
     *
     * @return string
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
     * Responds to the ajax request for to updated the logged in user data
     *
     * @return string
     */
    public function updateUserProfile(array $request){
        $user = $this->updateUser($request);
        echo json_encode($user);
        die();
    }
}