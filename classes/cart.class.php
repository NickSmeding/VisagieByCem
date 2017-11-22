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
    }
?>