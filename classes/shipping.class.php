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
        
        public function deleteShipping($id) {
            $deleteCategory = new Database();
            $deleteCategory->query("DELETE FROM shipping WHERE id = :id");
            $deleteCategory->bind(":id", $id);
            $deleteCategory->execute();
        }
        
        public function addCategory($categoryInfo) {

            $errorMsg = array();
            $handle = true;

            //quiery voor het op halen van om te kijken of hij al bestaat
            $selectAllShipping 

            //validatie voor opgegeven velden als er iets fout is geef error
            //voor optimaal gebruik van classes graag een validate class aanmaken wanneer er tijd voor is
            if ("" == trim($shippingInfo['name'])) {
                $errorMsg['name'] = "Shippingnaam is verplicht!";
                $handle = false;
            } else if ($selectAllShipping->rowCount() > 0) {
                $errorMsg['name'] = 'Deze shippingnaam is al ingebruik!';
                $handle = false;
            }
            // voor dit uit als handle true is dus als er geen error
            //controleer of een adres al bestaat in de database

            if ($handle == true) {

                $createShipping = new Database();
                $createShipping->query("INSERT INTO shipping (name)
            VALUES (:name)");
                $createShipping->bind(":name", $shippingInfo['name']);
                $createShipping->execute();

                header("Location: admin.shipping.php");
                return;
            } else {
                return $errorMsg;
            }
        }
    }
?>