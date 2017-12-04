<?php
    // ----- 
    class Product{
        
        
        public function __construct() 
        {
          
        }
        //haalt alleen producten op.
        public function selectAllProducts()
        {
            $selectAllProducts = new Database();
            $selectAllProducts->query("SELECT product.id, product.description, product.category, product.stock, product.name, product.price, product.active, image.path, image.date, image.filename FROM product INNER JOIN image ON product.img = image.id WHERE active = :active");
            $selectAllProducts->bind(":active", 1);
            $selectAllProducts->execute();
            $products = $selectAllProducts->resultset();
            
            return $products;      
        }
        
        //haalt product op op basis van $product_id
        public function selectSingleProduct($product_id)
        {
            $selectSingleProduct = new Database();
            $selectSingleProduct->query("SELECT * FROM product WHERE id = :id AND active = :active");
            $selectSingleProduct->bind(":id", $product_id);
            $selectSingleProduct->bind(":active", 1);
            $selectSingleProduct->execute();
            
            if ($selectSingleProduct->rowCount() > 0) {
                $product = $selectSingleProduct->single();    
                return $product;
            }
        }
    }
?>