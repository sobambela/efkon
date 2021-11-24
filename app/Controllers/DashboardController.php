<?php

namespace App\Controllers;

use App\DB;

class DashboardController extends DB
{
    public function index(){
        require_once 'templates/dashboard.php';
    }

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
        $user = $this->updateUser($request['user']);
        echo json_encode($user);
        die();
    }

    public function updateProfile(){
        
    }
}