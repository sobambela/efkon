<?php

namespace App\Controllers;

use App\DB;
use PHPMailer\PHPMailer\PHPMailer;

class AuthController extends DB
{
    /**
     * Displays the relevant template.
     */
    public function index(){
        require_once 'templates/auth/login.php';
    }

    /**
     * Displays the relevant template.
     */
    public function registerIndex(){
        require_once 'templates/auth/register.php';
    }
    
    /**
     * Displays the relevant template.
     */
    public function resetIndex(){
        require_once 'templates/auth/reset.php';
    }

    /**
     * Receives registration user data and stores in the database.
     *
     * @param  array $request The user data passed in the registration form
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
     * Authenticates the user.
     *
     * @param  array $request The user data passed in the login form
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
            }else{
                header('Location: /?inv=1');
            }
        }
        header('Location: /?inv=2');
    }

    /**
     * Returns the logged in user.
     * @return array
     */
    public function user(): array
    {
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
     * Checks if the user is authenticated.
     * @return bool
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
     * Logs the user out of the system.
     */
    public function logout(){
        session_start();
        session_unset();
        session_destroy();
        header('Location: /');
    }

    /**
     * Sends the password reset code to the user, Checks the user exists before sending email
     *
     * @param array $request The user specified route, as it appears in the Request URI
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
     * Sends the password reset code to the user
     *
     * @param  string  $email User email address
     * @param  string  $resetCode The password reset code
     * @return string
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
     * Validates the password reset code supplied by the user.
     *
     * @param  array  $request The form data from the request
     * @return string
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
     * Resets the user password and nullifies the password reset code.
     *
     * @param  array  $request The form data from the request
     * @return string
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