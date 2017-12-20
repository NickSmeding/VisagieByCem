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
            $selectAllProducts->query("SELECT product.id, product.description, product.category, product.stock, product.name, product.price, product.active, image.path, image.date, image.filename, category.name AS catname FROM product INNER JOIN image ON product.img = image.id INNER JOIN category ON category.id = product.category WHERE product.active = :active");
            $selectAllProducts->bind(":active", 1);
            $selectAllProducts->execute();
            $products = $selectAllProducts->resultset();
            
            return $products;      
        }
        
        //haalt product op op basis van $product_id
        public function selectSingleProduct($product_id)
        {
            $selectSingleProduct = new Database();
            $selectSingleProduct->query("SELECT product.id, product.description, product.category, product.stock, product.name, product.price, product.active, image.path, image.date, image.filename FROM product INNER JOIN image ON product.img = image.id WHERE product.id = :id AND product.active = :active");
            $selectSingleProduct->bind(":id", $product_id);
            $selectSingleProduct->bind(":active", 1);
            $selectSingleProduct->execute();
            
            if ($selectSingleProduct->rowCount() > 0) {
                $product = $selectSingleProduct->single();    
                return $product;
            }
        }
        
        //een product toevoegen
        public function productAdd($productInfo, $productImg)
        {
            $error = array();
            $handle = true;
            
            //kijk of een van deze velden leeg is zoja geef error
            if("" == trim($productInfo['name'])){
                $error['name'] = "De naam kan niet leeg zijn!";
                $handle = false;
            }if("" == trim($productInfo['price'])){
                $error['price'] = "Prijs is verplicht!";
                $handle = false;
            }else if(!is_numeric($productInfo['price'])){
                $error['price'] = "Prijs moet een nummer zijn!";
                $handle = false;
            }else if($productInfo['price'] < 0.01){
                $error['price'] = "Prijs moet minimaal 1 cent zijn!";
                $handle = false;
            }if("" == trim($productInfo['category'])){
                $error['category'] = "category moet gekozen zijn!";
                $handle = false;
            }if("" == trim($productInfo['stock'])){
                $error['stock'] = "aantal moet gekozen zijn!";
                $handle = false;
            }else if($productInfo['stock'] < 0){
                $error['stock'] = "aantal kan niet negatief zijn!";
                $handle = false;
            }
            
            //als handle niet false is ga dan dit uitvoeren
            if($handle == true){   
                //als er een foto is opgegeven upload die foto dan met gegeven gegevens
                if(!empty($productImg['fileToUpload']['name'])){
                    $imgUploader = new Uploader();
                    $imgUploader->setDestination('../assets/uploads/');
                    $imgUploader->setAllowedExtensions(array('image/jpg','image/jpeg','image/gif','image/png'));
                    $imgUploader->setFileName($productImg['fileToUpload']['name']);
                    $imgUploader->upload($productImg['fileToUpload']);
                    
                    //als er een error wordt terug gegevens van Uploader class sla die dan op in error array
                    if(!("" == trim($imgUploader->getError()))){
                        $error['img'] = $imgUploader->getError();
                    }
                }else{
                    $error['img'] = "U heeft geen foto gekozen!";   
                }
            }
            
            //als er geen errors zijn voer dit dan uit
            if(!$error){
                
                //maak nieuw img
                $newImg = new Database();
                $newImg->query("INSERT INTO image (path, date, filename) VALUES (:path, :date, :filename)");
                $newImg->bind(":path", "../assets/uploads/");
                $newImg->bind(":date", date("Y-m-d"));
                $newImg->bind(":filename", $productImg['fileToUpload']['name']);
                $newImg->execute();

                $imgID = $newImg->lastInsertedId();
                
                if(isset($imgID)){
                    //zet prijs om naar centen
                    $productPrice = ($productInfo['price'] * 100);

                    //voeg nieuw product toe aan database
                    $addProduct = new Database();
                    $addProduct->query("INSERT INTO `product`(name, price, category, img, description, stock, active) VALUES (:name, :price, :category, :img, :description, :stock, :active)");
                    $addProduct->bind(":name", $productInfo['name']);
                    $addProduct->bind(":description", $productInfo['description']);
                    $addProduct->bind(":stock", $productInfo['stock']);
                    $addProduct->bind(":price", $productPrice);
                    $addProduct->bind(":category", $productInfo['category']);
                    $addProduct->bind(":img", $imgID);
                    $addProduct->bind(":active", "1");
                    $addProduct->execute();

                    $result['succes'] = 'succes';
                    return $result;
                    //redirect naar admin.products.php
                    //header("location: adminProductOverview.php");
                    //die();
                }else{
                    $error['imgUpload'] = "Er is een fout opgetreden bij het toevoegen van de foto!";    
                }
            }else{
                return $error;
            }
        }
    }
?>