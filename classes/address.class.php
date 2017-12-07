<?php
    class Address{
        
        //constructor
        public function __construct() 
        {
           
        }
        
        public function checkAddress($userinfo){
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
                $addressID = $this->addAddress($userinfo);
            }else{
                $EXaddress = $checkAddress->single();
                $addressID = $EXaddress['id'];
            }        
            
            return $addressID;
        }
        
        public function addAddress($userinfo){
     
            //maak nieuw adres
            $newAddress = new Database();
            $newAddress->query("INSERT INTO Address (zip, housenumber, extension, city, street) VALUES (:zip, :housenumber, :extension, :city, :street)");
            $newAddress->bind(":housenumber", $userinfo['housenumber']);
            $newAddress->bind(":zip", $userinfo['zip']);
            $newAddress->bind(":extension", $userinfo['extension']);
            $newAddress->bind(":city", $userinfo['city']);
            $newAddress->bind(":street", $userinfo['street']);
            $newAddress->execute();  
            
            return $newAddress->lastInsertedId();
        }
    }
?>