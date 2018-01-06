<?php

class Category {

    public function __construct() {

    }

    //haalt alleen categoryen op
    public function selectAllCategories() {
        $selectAllCategories = new Database();
        $selectAllCategories->query("SELECT id, name FROM category");
        $selectAllCategories->execute();
        $categories = $selectAllCategories->resultset();

        return $categories;
    }

    public function deleteCategory($id) {
        $deleteCategory = new Database();
        $deleteCategory->query("DELETE FROM category WHERE id = :id");
        $deleteCategory->bind(":id", $id);
        $deleteCategory->execute();
    }

    public function selectSingleCategory($category_id) {
        $selectSingleCategory = new Database();
        $selectSingleCategory->query("SELECT id, name FROM category WHERE id = :id");
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
        $selectAllCategories = new Database();
        $selectAllCategories->query("SELECT name FROM category WHERE :name = name");
        $selectAllCategories->bind(":name", $categoryInfo['name']);
        $selectAllCategories->execute();

        //validatie voor opgegeven velden als er iets fout is geef error
        //voor optimaal gebruik van classes graag een validate class aanmaken wanneer er tijd voor is
        if ("" == trim($categoryInfo['name'])) {
            $errorMsg['name'] = "Categorienaam is verplicht!";
            $handle = false;
        } else if ($selectAllCategories->rowCount() > 0) {
            $errorMsg['name'] = 'Deze categorienaam is al ingebruik!';
            $handle = false;
        }

        if ($handle == true) {

            $categoryUpdate = new Database();
            $categoryUpdate->query("UPDATE category SET name = :name WHERE id = :id");
            $categoryUpdate->bind(":id", $categoryInfo['id']);
            $categoryUpdate->bind(":name", $categoryInfo['name']);
            $categoryUpdate->execute();

            header("Location: admin.categories.php");
            return;
        } else {
            return $errorMsg;
        }



        header("Location: ../index.php");
        exit();
    }
//Deze functie voegt een categorie toe
    public function addCategory($categoryInfo) {

        $errorMsg = array();
        $handle = true;

        //quiery voor het op halen van om te kijken of hij al bestaat
        $selectAllCategories = new Database();
        $selectAllCategories->query("SELECT name FROM category WHERE :name = name");
        $selectAllCategories->bind(":name", $categoryInfo['name']);
        $selectAllCategories->execute();

        //validatie voor opgegeven velden als er iets fout is geef error
        //voor optimaal gebruik van classes graag een validate class aanmaken wanneer er tijd voor is
        if ("" == trim($categoryInfo['name'])) {
            $errorMsg['name'] = "Categorienaam is verplicht!";
            $handle = false;
        } else if ($selectAllCategories->rowCount() > 0) {
            $errorMsg['name'] = 'Deze categorienaam is al ingebruik!';
            $handle = false;
        }
        // voor dit uit als handle true is dus als er geen error
        //controleer of een adres al bestaat in de database

        if ($handle == true) {

            $createCategory = new Database();
            $createCategory->query("INSERT INTO category (name)
        VALUES (:name)");
            $createCategory->bind(":name", $categoryInfo['name']);
            $createCategory->execute();

            header("Location: admin.categories.php");
            return;
        } else {
            return $errorMsg;
        }
    }

}

?>