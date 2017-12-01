<?php
    class User{
        
        private $email;    // email variable
        private $password; // password variable
        private $user;     // user data variable
        
        //constructor
        public function __construct() 
        {
           
        }
        
        //probeer in teloggen met opgegeven gegevens
        public function login($email, $password)
        {
            $this->email = $email;
            $this->password = $password; 
            //bekijk of user gegevens kloppen
            $user = $this->checkLoginUser();
            
            //als user gegevens kloppen sla dan user id op in een session (je bent ingelogd)
            if ($user) {
                $this->user = $user; 
                $_SESSION['user_id'] = $user['id'];
                
                return $user['id'];
            }
            
            return false;
        }

        //controleer opgeven gegevens
        private function checkLoginUser()
        {
            $db = new Database();
            $db->query("SELECT * FROM customer WHERE email = :email");
            $db->bind(":email", $this->getEmail());
            $db->execute();
            if ($db->rowCount() > 0) {
                $user = $db->single();
                $input_password = $this->getHash($this->getPassword(), $this->getEmail());  
                if ($input_password == $user['password']) {
                    return $user;
                }
            }
            
            return false;
        }
        
        //kijk of er iemand ingelogd is
        public function checkUser()
        {
            if(isset($_SESSION['user_id'])){
                return true;
            }else{
                return false;    
            }
        }
        
        //logout
        public function logout()
        {
            session_start();

            unset($_SESSION['user_id']);  
            
            header("Location: ../../index.php");
            exit();
        }
        
        //haal een user op gebaseerd op user_id
        public function getUserData($user_id)
        {  
            $userData = new Database();
            $userData->query("SELECT * FROM customer WHERE id = :id");
            $userData->bind(":id", $user_id);
            $userData->execute();
            if ($userData->rowCount() > 0) {
                $user = $userData->single();
                return $user;
            }
        }
        
        //functie om wachtwoord te hashen
        public function getHash($password, $salt)
        {
           return  hash_hmac('sha256', $password, $salt);
        }
        
        //getters
        public function getEmail() 
        { 
            return $this->email; 
        }   
        
        public function getPassword() 
        { 
            return $this->password; 
        }   
    }
?>