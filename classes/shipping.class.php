<?php 
    class Shipping{
        
        
        public function __construct() 
        {
          
        }
        
        //haalt alleen categoryen op
        public function selectAllShipping()
        {
            $selectAllShipping = new Database();
            $selectAllShipping->query("SELECT method, fee FROM shipping");
            $selectAllShipping->execute();
            $shipping = $selectAllShipping->resultset();
            
            return $shipping;     
        }
    }
?>