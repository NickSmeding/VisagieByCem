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
    }
?>