<?php

namespace App\Controllers;

use App\DB;
use App\Controllers\AuthController;

class DashboardController extends DB
{
    protected $auth;

    public function __construct()
    {
        parent::__construct();
        $auth = new AuthController;
        $this->auth = $auth->check();
    }

    public function index(){
        if($this->auth){
            require_once 'templates/dashboard.php';
        }else{
            header('Location: /');
        }
    }

    public function profileIndex(){
        if($this->auth){
            require_once 'templates/profile.php';
        }else{
            header('Location: /');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fish  $Fish
     * @return \Illuminate\Http\Response
     */
    public function getAllUsers($request){
        $sort = $request['sort'];
        echo json_encode($this->getUsers($sort));
        die();
    }

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
    
    public function updateUserProfile(array $request){
        $user = $this->updateUser($request);
        echo json_encode($user);
        die();
    }
}