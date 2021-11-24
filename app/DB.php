<?php

namespace App;

class DB
{
    protected $serverName;
    protected $databaseName;
    protected $databaseUser;
    protected $databasePassword;
    protected $db;

    public function __construct()
    {
        $this->serverName = getenv('DATABASE_HOST');
        $this->databaseName = getenv('DATABASE_NAME');
        $this->databaseUser = getenv('DATABASE_USER');
        $this->databasePassword = getenv('DATABASE_PASSWORD');

        $this->db = new \mysqli($this->serverName, $this->databaseUser, $this->databasePassword, $this->databaseName);
    
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public function createUser(array $user): bool
    {
        try {
            $this->db->autocommit(FALSE);
            $stmt = $this->db->prepare("INSERT INTO users (name, surname, gender, contact_number, email, password, reset_token) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $name, $surname, $gender, $contact_number, $email, $password, $reset_token);
            
            $name= $user['name'];
            $surname= $user['surname'];
            $gender= $user['gender'];
            $contact_number= $user['contact_number'];
            $email= $user['email'];
            $reset_token= md5($user['email']);
            $password= md5($user['password']);

            $stmt->execute();
            $user_id = $this->db->insert_id;
            $this->db->commit();
            $stmt->close();
            $this->db->close();

            return $user_id;  
        } catch (\mysqli_sql_exception $exception) {
            $this->db->rollback();
            throw $exception;
        }
    }

    public function updateUser(array $user): string
    {
        try {
            $this->db->autocommit(FALSE);
            // Password Check
            $email = $user['email'];
            $old_password = $user['old_password'];
            $id= $user['id'];
            $name= $user['name'];
            $surname= $user['surname'];
            $gender= $user['gender'];
            $contact_number= $user['contact_number'];
            $password= md5($user['new_password']);
            
            $stmt = $this->db->prepare("SELECT id,email, password FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if(!is_null($user) && count($user) > 0){
                $storedPass = $user['password'];
                if(md5($old_password) !== $storedPass){
                    echo json_encode(['success' => false, 'message' => 'You entered an invalid Old password']);
                    die();
                }
            }else{
                echo json_encode(['success' => false, 'message' => 'Could not locate user']);
                die();
            }

            $stmt = $this->db->prepare("UPDATE `users` SET name = ?, surname = ?, gender = ?, contact_number = ?, email = ?, password = ?  WHERE users.id = ?;");
            $stmt->bind_param("ssssssi", $name, $surname, $gender, $contact_number, $email, $password, $id);
            $result = $stmt->execute();
            $this->db->commit();

            $stmt->close();
            $this->db->close();

            echo json_encode(['success' => true, 'message' => 'Success']);
            die();
        } catch (\mysqli_sql_exception $e) {
            $this->db->rollback();
            echo json_encode(['success' => false, 'message' => $e.getMessage()]);
            die();
        }
    }

    public function getUsers(string $sort){
        $sql = "SELECT `id`, `name`, `surname`, `gender`, `contact_number`, `email`, `password` FROM users ORDER BY name $sort";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $results = [];
        while($row = $result->fetch_assoc()) {
            array_push($results, [
                'id' => $row['id'],
                'name' => $row['name'],
                'surname' => $row['surname'],
                'gender' => $row['gender'],
                'contact_number' => $row['contact_number'],
                'email' => $row['email'],
                'password' => $row['password']
            ]);
        }
        return $results;
    }
}