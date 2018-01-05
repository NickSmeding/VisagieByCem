<?php 
    class Category{
        
        
        public function __construct() 
        {
          
        }
        
        //haalt alleen categoryen op
        public function selectAllCategories()
        {
            $selectAllCategories = new Database();
            $selectAllCategories->query("SELECT id, name FROM category");
            $selectAllCategories->execute();
            $categories = $selectAllCategories->resultset();
            
            return $categories;      
        }
    
        public function deleteCategory() {
            $deleteCategory = new Database();
            $deleteCategory->query("DELETE FROM category WHERE id = :id");
            $deleteCategory->bind(":id", $id);
            $deleteCategory->execute();
        }

        public function selectSingleCategory($category_id) {
            $selectSingleCategory = new Database();
            $selectSingleCategory->query("SELECT id, name FROM category");
            $selectSingleCategory->bind(":id", $category_id);
            $selectSingleCategory->execute();

            if ($selectSingleCategory->rowCount() > 0) {
                $category = $selectSingleCategory->single();
                return $category;
            }
        }

        public function updateCategory($categoryInfo) {

            $errorMsg = array();
            $handle = true;

            //quiery voor het op halen van om te kijken of hij al bestaat
            $updateCategory = new Database();
            $updateCategory->query("SELECT id FROM category WHERE :id = id");
            $updateCategory->bind(":id", $categoryInfo['id']);
            $updateCategory->execute();

            $categoryUpdate = new Database();

            $categoryUpdate->query("INSERT INTO category (id, name)
            VALUES (:id, :name)");

            $categoryUpdate->bind(":id", $userInfo['id']);
            $categoryUpdate->bind(":name", $userInfo['name']);

            $categoryUpdate->execute();

            header("Location: ../index.php");
            exit();
        }

    }

?>