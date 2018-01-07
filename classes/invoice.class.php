<?php
    class Invoice{
        
        private $btw;
        
        //constructor
        public function __construct() 
        {
           $this->btw = '21';
        }
        
        //ophalen van een factuur gebaseerd op invoice_id
        public function selectSingleInvoice($invoice_id)
        {
            $invoiceData = new Database();
            $invoiceData->query("SELECT * FROM invoice
            INNER JOIN invoice_line ON invoice_line.invoice = invoice.id INNER JOIN shipping ON shipping.method = invoice.shipping WHERE invoice.id = :invoice_id");
            $invoiceData->bind(":invoice_id", $invoice_id);
            $invoiceData->execute();
            
            $invoice = $invoiceData->resultset();
            return $invoice;
        }
        
        //toevoegen van een factuur
        public function insertInvoice($shipping)
        { 
            $date = date("Y-m-d");

            $insertInvoice = new Database();
            $insertInvoice->query("INSERT INTO invoice (date, customer, status, btw, employee, shipping) VALUES (:date, :customer, :status, :btw, :employee, :shipping)");
            $insertInvoice->bind("date", $date);
            $insertInvoice->bind(":customer", $_SESSION['user_id']);
            $insertInvoice->bind(":status", 0);
            $insertInvoice->bind(":btw", $this->getBtw());
            $insertInvoice->bind(":employee", NULL);
            $insertInvoice->bind(":shipping", $shipping);
            $insertInvoice->execute();
            
            $lastId = $insertInvoice->lastInsertedId();
                
            return $lastId;
        }
        
        //toevoegen van alle factuur regels die bij gegeven factuur horen
        public function insertInvoiceLine($invoice_id)
        { 
            $insertInvoiceLine = new Database();
            $productClass = new Product();
            
            foreach($_SESSION["cart"] as $product_id => $product){ 
                $productInfo = $productClass->selectSingleProduct($product_id);
                
                $insertInvoiceLine->query("INSERT INTO `invoice_line` (invoice, product, quantity, price_unit) VALUES (:invoice, :product, :quantity, :price_unit)");
                $insertInvoiceLine->bind(":invoice", $invoice_id);
                $insertInvoiceLine->bind(":price_unit", $productInfo['price']);
                $insertInvoiceLine->bind(":product", $productInfo['id']);
                $insertInvoiceLine->bind(":quantity", $product['quantity']);
                $insertInvoiceLine->execute();
            }
            
            //winkelwagen leeg halen.
            unset($_SESSION['cart']);
            header('Location: invoice.php?id='.$invoice_id);
            die();
        }
        
        public function selectAllInvoice() {
            $selectAllInvoice = new Database();
            $selectAllInvoice->query("SELECT customer.lastname, customer.firstname, customer.id, invoice.id, invoice.date, invoice.customer, invoice.status, invoice.btw, invoice.employee, invoice.shipping FROM customer JOIN invoice ON customer.id=invoice.customer");

            $selectAllInvoice->execute();
            $invoice = $selectAllInvoice->resultset();

            return $invoice;
        }

        public function updateOrder($id) {
            $updateOrder = new Database();
            $updateOrder->query("UPDATE invoice SET status=2 WHERE :id = $id");
            $updateOrder->bind(":id", $id);
            $updateOrder->execute();
            $orderUpdate = $updateOrder->resultset();
            return $orderUpdate;
        }
        
        public function getBtw() 
        { 
            return $this->btw; 
        }
    }
?>