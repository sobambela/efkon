<?php

namespace App\Controllers;

use App\DB;

class AuthController extends DB
{
    public function index(){
        require_once 'templates/auth/login.php';
    }

    public function registerIndex(){
        require_once 'templates/auth/register.php';
    }

    public function register(array $request){
        $user_id = $this->createUser($request);
        if($user_id){
            session_start();
            $_SESSION['guest'] = false;
            $_SESSION['user_id'] = $user_id;
            header('Location: /dashboard');
        }else{
            $_SESSION['guest'] = true;
            header('Location: /register');
        }
    }

    public function login(array $request){
        $email = $request['email'];
        $password = $request['password'];

        $stmt = $this->db->prepare("SELECT id,email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if(!is_null($user) && count($user) > 0){
            $storedPass = $user['password'];
            if(md5($password) == $storedPass){
                session_start();
                $_SESSION['guest'] = false;
                $_SESSION['user_id'] = $user['id'];
                header('Location: /dashboard');
            }
        }
        return false;
    }

    public function user(){
        session_start();
        $id = $_SESSION['user_id'];

        $stmt = $this->db->prepare("SELECT id,email, password FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        return $user;
    }

    public function check(): bool
    {
        session_start();
        if(!isset($_SESSION['guest']) || $_SESSION['guest'] == true){
            return false;
        }else{
            return true;
        }
    }

    public function logout(){
        session_start();
        session_unset();
        session_destroy();
        header('Location: /');
    }

    public function resetPassword(){
        
    }
}