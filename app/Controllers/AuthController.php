<?php

namespace App\Controllers;

use App\DB;
use PHPMailer\PHPMailer\PHPMailer;

class AuthController extends DB
{
    /**
     * Routes the URI of the GET method to the specified controller.
     */
    public function index(){
        require_once 'templates/auth/login.php';
    }

    /**
     * Routes the URI of the GET method to the specified controller.
     */
    public function registerIndex(){
        require_once 'templates/auth/register.php';
    }
    
    /**
     * Routes the URI of the GET method to the specified controller.
     */
    public function resetIndex(){
        require_once 'templates/auth/reset.php';
    }

    /**
     * Routes the URI of the GET method to the specified controller.
     *
     * @param  string  $route The user specified route, as it appears in the Request URI
     * @param  string  $targetControllerPath The fully qualified namespace path to the target controller
     * @param  string  $controllerMethod The method that will be called in the target controller
     * @return mix
     */
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

    /**
     * Routes the URI of the GET method to the specified controller.
     *
     * @param  string  $route The user specified route, as it appears in the Request URI
     * @param  string  $targetControllerPath The fully qualified namespace path to the target controller
     * @param  string  $controllerMethod The method that will be called in the target controller
     * @return mix
     */
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

    /**
     * Routes the URI of the GET method to the specified controller.
     *
     * @param  string  $route The user specified route, as it appears in the Request URI
     * @param  string  $targetControllerPath The fully qualified namespace path to the target controller
     * @param  string  $controllerMethod The method that will be called in the target controller
     * @return mix
     */
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

    /**
     * Routes the URI of the GET method to the specified controller.
     *
     * @param  string  $route The user specified route, as it appears in the Request URI
     * @param  string  $targetControllerPath The fully qualified namespace path to the target controller
     * @param  string  $controllerMethod The method that will be called in the target controller
     * @return mix
     */
    public function check(): bool
    {
        session_start();
        if(!isset($_SESSION['guest']) || $_SESSION['guest'] == true){
            return false;
        }else{
            return true;
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
    public function logout(){
        session_start();
        session_unset();
        session_destroy();
        header('Location: /');
    }

    /**
     * Routes the URI of the GET method to the specified controller.
     *
     * @param  string  $route The user specified route, as it appears in the Request URI
     * @param  string  $targetControllerPath The fully qualified namespace path to the target controller
     * @param  string  $controllerMethod The method that will be called in the target controller
     * @return mix
     */
    public function sendResetEmail(array $request){
        
        $email = $request['email'];
        $resetCode = random_int(100000, 999999);
            
        $stmt = $this->db->prepare("SELECT id,email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if(!is_null($user) && count($user) > 0){
            $updateStmnt = $this->db->prepare("UPDATE `users` SET `reset_token` = ? WHERE `users`.`email` = ?");
            $updateStmnt->bind_param("is", $resetCode, $email);
            $update = $updateStmnt->execute();
    
            if(!$update){
                echo json_encode(['success' => false, 'message' => 'DB Error!']);
                die();
            }
        }else{
            echo json_encode(['success' => false, 'message' => 'Could not locate user']);
            die();
        }

        $this->sendEmail($email, $resetCode);
    }

    /**
     * Routes the URI of the GET method to the specified controller.
     *
     * @param  string  $route The user specified route, as it appears in the Request URI
     * @param  string  $targetControllerPath The fully qualified namespace path to the target controller
     * @param  string  $controllerMethod The method that will be called in the target controller
     * @return mix
     */
    public function sendEmail(string $email, string $resetCode)
    {

        $mail = new PHPMailer;
        $mail->isSMTP();                                    // Set mailer to use SMTP
        $mail->Host = getenv('SMTP_HOST');                  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                             // Enable SMTP authentication
        $mail->Username = getenv('SMTP_USERNAME');          // SMTP username
        $mail->Password = getenv('SMTP_PASSWORD');                    // SMTP password
        $mail->SMTPSecure = 'ssl';                          // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                  // TCP port to connect to
        $mail->setFrom(getenv('EMAIL_FROM'), 'Efkon Assessment');
        $mail->addAddress($email);
        $mail->addAddress('payment_reports@livingfountain.co.za');
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Body = "Your Password reset code is " .  $resetCode;
        $mail->Subject = 'Password Reset';
    
        //send the message, check for errors
        if (!$mail->send()) {
            echo json_encode(['success' => false, 'message' => 'Mail send error Error!']);
            die();
        } else {
            echo json_encode(['success' => true, 'message' => 'Password reset code has been sent to your email']);
            die();
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
    public function verifyPasswordResetCode(array $request)
    {
        $code = $request['code'];
        $email = $request['email'];
            
        $stmt = $this->db->prepare("SELECT id,email, password FROM users WHERE email = ? AND reset_token = ?");
        $stmt->bind_param("si", $email, $code);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if(!is_null($user) && count($user) > 0){
            echo json_encode(['success' => true, 'message' => 'Please update your password']);
            die();
        }else{
            echo json_encode(['success' => false, 'message' => 'Invalid reset code']);
            die();
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
    public function resetPassword(array $request)
    {
        $password = md5($request['password']);
        $email = $request['email'];

        $updateStmnt = $this->db->prepare("UPDATE `users` SET `password` = ?, `reset_token` = NULL WHERE `users`.`email` = ?");
        $updateStmnt->bind_param("ss", $password, $email);
        $update = $updateStmnt->execute();

        if(!$update){
            echo json_encode(['success' => false, 'message' => 'DB Error!']);
            die();
        }else{
            echo json_encode(['success' => true, 'message' => 'Password updated...redirecting']);
            die();
        }
    }
}