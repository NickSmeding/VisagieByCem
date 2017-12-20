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
        public function login($email, $password, $admin)
        {
            $this->email = $email;
            $this->password = $password;  
            
            if($admin){
                //bekijk of user gegevens kloppen
                $admin = $this->checkLoginAdmin();

                //als admin gegevens kloppen sla dan user id op in een session (je bent ingelogd)
                if ($admin) {
                    $this->admin = $admin; 
                    $_SESSION['admin_id'] = $admin['id'];

                    return $admin['id'];
                }

                return false;
                
            }else{
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
        
        //controleer opgeven gegevens
        private function checkLoginAdmin()
        {
            $db = new Database();
            $db->query("SELECT * FROM employee WHERE email = :email");
            $db->bind(":email", $this->getEmail());
            $db->execute();
            if ($db->rowCount() > 0) {
                $admin = $db->single();
                $input_password = $this->getHash($this->getPassword(), $this->getEmail());  
                if ($input_password == $admin['password']) {
                    return $admin;
                }
            }
            
            return false;
        }
        
        //kijk of er customer ingelogd is
        public function checkUser()
        {
            if(isset($_SESSION['user_id'])){
                return true;
            }else{
                return false;    
            }
        }
        
        //kijk of er admin ingelogd is
        public function checkAdmin()
        {
            if(isset($_SESSION['admin_id'])){
                return true;
            }else{
                return false;    
            }
        }
        
        //haal alleen user op
        public function selectAllUsers()
        {
            $selectAllUsers = new Database();
            $selectAllUsers->query("SELECT * FROM customer");
            $selectAllUsers->execute();
            $users = $selectAllUsers->resultset();
            
            return $users;      
        }
        
        
        public function register($userInfo) {

            $errorMsg = array();
            $handle = true;
            
            //quiery voor het op halen van om te kijken of hij al bestaat
            $selectAllUsers = new Database();
            $selectAllUsers->query("SELECT email FROM customer WHERE :email = email");
            $selectAllUsers->bind(":email", $userInfo['email']);
            $selectAllUsers->execute();

            //validatie voor opgegeven velden als er iets fout is geef error
            //voor optimaal gebruik van classes graag een validate class aanmaken wanneer er tijd voor is
            if ("" == trim($userInfo['firstName'])) {
                $errorMsg['firstName'] = "Voornaam is verplicht!";
                $handle = false;
            }if ("" == trim($userInfo['lastName'])) {
                $errorMsg['lastName'] = "Achternaam is verplicht!";
                $handle = false;
            }if ("" == trim($userInfo['email'])) {
                $errorMsg['email'] = "Email-adres is verplicht!";
                $handle = false;
            }else if($selectAllUsers->rowCount() > 0){
                $errorMsg['email'] = 'Dit email adress is al ingebruik!';
                $handle = false;
            }if ("" == trim($userInfo['phoneNumber'])) {
                $errorMsg['phoneNumber'] = "Telefoonnummer is verplicht!";
                $handle = false;
            }if ("" == trim($userInfo['dateOfBirth'])) {
                $errorMsg['dateOfBirth'] = "Geboortedatum is verplicht!";
                $handle = false;
            }if ("" == trim($userInfo['city'])) {
                $errorMsg['city'] = "Plaats is verplicht!";
                $handle = false;
            }if ("" == trim($userInfo['postalCode'])) {
                $errorMsg['postalCode'] = "Postcode is verplicht!";
                $handle = false;
            }if ("" == trim($userInfo['streetName'])) {
                $errorMsg['streetName'] = "Straatnaam is verplicht!";
                $handle = false;
            }if ("" == trim($userInfo['houseNumber'])) {
                $errorMsg['houseNumber'] = "Huisnummer is verplicht!";
                $handle = false;
            }if ("" == trim($userInfo['password'])) {
                $errorMsg['password'] = "Wachtwoord is verplicht!";
                $handle = false;
            }else if (!($userInfo['password'] == $userInfo['confirmPassword'])) {
                $errorMsg['password'] = "De Wachtwoorden komen niet overeen!";
                $handle = false;
            }else if (strlen(trim($userInfo['password'])) < 8) {
                $errorMsg['password'] = "Het wachtwoord moet minimaal 8 characters lang zijn!";
                $handle = false;
            }else if(!(preg_match('/[^0-9a-z\.\&\@]/i', $userInfo['password']))){
                $errorMsg['password'] = "Het wachtwoord moet minimaal een character hebben dat geen nummer of letter is!";
                $handle = false;
            }if(!$userInfo['g-recaptcha-response']){
                $errorMsg['robot'] = "Klik de ik ben geen robot knop aan!";
                $handle = false;
            }
            
            // voor dit uit als handle true is dus als er geen error
            //controleer of een adres al bestaat in de database
            
            if ($handle == true) {
                //query voor address gegevens
                $checkAddress = new Database();
                $checkAddress->query("SELECT id FROM Address WHERE zip = :zip AND housenumber = :housenumber AND extension = :extension AND city = :city AND street = :street");
                $checkAddress->bind(":housenumber", $userInfo['houseNumber']);
                $checkAddress->bind(":zip", $userInfo['postalCode']);
                $checkAddress->bind(":extension", $userInfo['addition']);
                $checkAddress->bind(":city", $userInfo['city']);
                $checkAddress->bind(":street", $userInfo['streetName']);
                $checkAddress->execute();

                if($checkAddress->rowCount() <= 0){ 

                    //maak nieuw adres
                    $newAddress = new Database();
                    $newAddress->query("INSERT INTO Address (zip, housenumber, extension, city, street) VALUES (:zip, :housenumber, :extension, :city, :street)");
                    $newAddress->bind(":housenumber", $userInfo['houseNumber']);
                    $newAddress->bind(":zip", $userInfo['postalCode']);
                    $newAddress->bind(":extension", $userInfo['addition']);
                    $newAddress->bind(":city", $userInfo['city']);
                    $newAddress->bind(":street", $userInfo['streetName']);
                    $newAddress->execute();

                    $addressID = $newAddress->lastInsertedId();
                }else{
                    $EXaddress = $checkAddress->single();
                    $addressID = $EXaddress['id'];
                }

                $customerRegistration = new Database();

                $customerRegistration->query("INSERT INTO customer (firstname, insertion, lastname, password, email, address, phone, birthdate, active)
        VALUES (:firstName, :insertion, :lastName, :password, :email, :address, :phoneNumber, :birthdate, :active)");

                $customerRegistration->bind(":firstName", $userInfo['firstName']);
                $customerRegistration->bind(":insertion", $userInfo['insertion']);
                $customerRegistration->bind(":lastName", $userInfo['lastName']);
                $customerRegistration->bind(":password", $this->getHash($userInfo['password'], $userInfo['email']));
                $customerRegistration->bind(":email", $userInfo['email']);
                $customerRegistration->bind(":phoneNumber", $userInfo['phoneNumber']);
                $customerRegistration->bind(":address", $addressID);
                $customerRegistration->bind(":birthdate", $userInfo['dateOfBirth']);
                $customerRegistration->bind(":active", 1);

                $customerRegistration->execute();
                
                $this->login($userInfo['email'], $userInfo['password'], false);
                header("Location: ../index.php");
                exit();
            } else {
                return $errorMsg;
            }
        }
        
        //verander gegevens van user
        public function userUpdate($userinfo, $user_id)
        { 
            $errorMsg = array();
            $handle = true;
            $user = $this->getUserData($user_id);
            $input_password = $this->getHash($userinfo['oldpass'], $user['email']); 
            
            //validatie voor opgegeven gegevens
            if("" == trim($userinfo['firstname'])){
                $errorMsg['firstname'] = "Voorletters zijn verplicht!";
                $handle = false;
            }if("" == trim($userinfo['lastname'])){
                $errorMsg['lastname'] = "Achternaam is verplicht!";
                $handle = false;
            }if("" == trim($userinfo['birthdate'])){
                $errorMsg['birthdate'] = "Geboortedatum is verplicht!";
                $handle = false;
            }if("" == trim($userinfo['e-mail'])){
                $errorMsg['e-mail'] = "Email is verplicht!";
                $handle = false;
            }if("" == trim($userinfo['phone'])){
                $errorMsg['phone'] = "Telefoonnummer is verplicht!";
                $handle = false;
            }if("" == trim($userinfo['city'])){
                $errorMsg['city'] = "Plaats is verplicht!";
                $handle = false;
            }if (!($user['password'] == $input_password)) {
                $errorMsg['oldpass'] = "het oude wachtwoord komt niet overeen!";
                $handle = false;
            }if(!("" == trim($userinfo['newpass']))){
                if(strlen(trim($userinfo['newpass'])) < 8){
                    $errorMsg['newpass'] = "Wachtwoord te kort!";
                    $handle = false;
                }else if(!(preg_match('/[^0-9a-z\.\&\@]/i', $userinfo['newpass']))){
                    $errorMsg['newpass'] = "Het wachtwoord moet minimaal een character hebben dat geen nummer of letter is!";
                    $handle = false;
                }else{
                    $input_password = $this->getHash($userinfo['newpass'], $userinfo['e-mail']); 
                }            
            }else{
                $input_password = $this->getHash($userinfo['oldpass'], $userinfo['e-mail']);     
            }
            
            // als handle niet false is en er dus geen errors zijn update dan de user
            if($handle == true){

                //controleer of een adres al bestaat in de database
                $checkAddress = new Database();
                $checkAddress->query("SELECT id FROM Address WHERE zip = :zip AND housenumber = :housenumber AND extension = :extension AND city = :city AND street = :street");
                $checkAddress->bind(":housenumber", $userinfo['housenumber']);
                $checkAddress->bind(":zip", $userinfo['zip']);
                $checkAddress->bind(":extension", $userinfo['extension']);
                $checkAddress->bind(":city", $userinfo['city']);
                $checkAddress->bind(":street", $userinfo['street']);
                $checkAddress->execute();
                
                if($checkAddress->rowCount() <= 0){ 
                    
                    //maak nieuw adres
                    $newAddress = new Database();
                    $newAddress->query("INSERT INTO Address (zip, housenumber, extension, city, street) VALUES (:zip, :housenumber, :extension, :city, :street)");
                    $newAddress->bind(":housenumber", $userinfo['housenumber']);
                    $newAddress->bind(":zip", $userinfo['zip']);
                    $newAddress->bind(":extension", $userinfo['extension']);
                    $newAddress->bind(":city", $userinfo['city']);
                    $newAddress->bind(":street", $userinfo['street']);
                    $newAddress->execute();
                    
                    $addressID = $newAddress->lastInsertedId();
                }else{
                    $EXaddress = $checkAddress->single();
                    $addressID = $EXaddress['id'];
                }
                
                //update user
                $updateUser = new Database();
                $updateUser->query("UPDATE customer SET firstname = :firstName, insertion = :insertion, lastname = :lastName, address = :address, birthdate = :birthdate, email = :email, phone = :phone, password = :pass WHERE id = :userid");
                $updateUser->bind(":firstName", $userinfo['firstname']);
                $updateUser->bind(":insertion", $userinfo['insertion']);
                $updateUser->bind(":lastName", $userinfo['lastname']);
                $updateUser->bind(":address", $addressID);
                $updateUser->bind(":birthdate", $userinfo['birthdate']);
                $updateUser->bind(":email", $userinfo['e-mail']);
                $updateUser->bind(":phone", $userinfo['phone']);               
                $updateUser->bind(":userid", $user_id);
                $updateUser->bind(":pass", $input_password);
                $updateUser->execute();
                
                $msg['succes'] = "Update is gelukt!";
                return $msg;
                //header("Location: admin.users.php");
                //exit();
            }else{
                return $errorMsg;
            }
        }
        
        //logout
        public function logout($admin)
        {

            if($admin){
                unset($_SESSION['admin_id']);
            }else{
                unset($_SESSION['user_id']);  
            }
            
            header("Location: ../../index.php");
            exit();
        }
        
        //haal een user op gebaseerd op user_id
        public function getUserData($user_id)
        {  
            $userData = new Database();
            $userData->query("SELECT * FROM customer INNER JOIN address ON customer.address = address.id WHERE customer.id = :id");
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