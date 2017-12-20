<?php
    class Cart{
        //constructor
        public function __construct() 
        {
           
        }
        //toevoegen van producten in een session voor het winkelwagentje en het vervangen van het product als hij al in het winkelwagentje zat.
        public function cartAdd($input)
        {
            unset($_SESSION["cart"][$_POST['product_id']]["quantity"]);
            $_SESSION["cart"][$_POST['product_id']]["quantity"] = $_POST['quantity'];     
        }
        
        //product verwijderen uit het winkelwagentje
        public function cartDelete($product_id)
        {
            unset($_SESSION["cart"][$product_id]);   
        }
        
        //het afhandelen van het winkelwagentje
        public function checkoutCart($shipping){

            $userClass = new User();
            
            //is er iemand ingelogd ja of nee
            if($userClass->checkUser()){
                //zit er wat in het winkelwagentje ja of nee
                if(isset($_SESSION["cart"]) && count($_SESSION['cart']) > 0){
                    
                    //voeg factuur toe
                    $invoiceClass = new Invoice();
                    $invoiceId = $invoiceClass->insertInvoice($shipping);
                    
                    //voeg factuur regels toe 
                    if(isset($invoiceId)){
                        $invoiceClass->insertInvoiceLine($invoiceId);
                    }
                    
                }else{
                    $error = "U heeft geen product toegevoegd!"; 
                    return $error;
                }
            }else{
                $error = "U bent niet ingelogd!";
                return $error;
            }
        }
    }
?>