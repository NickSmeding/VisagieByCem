<!DOCTYPE html>

<html>
    <?php
        session_start();
        include_once '../classes/database.class.php';
        include_once '../classes/user.class.php';
        include_once '../classes/uploader.class.php';
        include_once '../classes/product.class.php';
        include_once '../classes/category.class.php';
        include_once 'inc/head.php';

        $userClass = new User();
        $productClass = new Product(); //maakt verbinding met product.class
        $categoryClass = new Category();

        if(!$userClass->checkAdmin()){
            header("Location: admin.php");
            exit();
        }

        if(isset($_POST["submitAddProduct"])) {
            $productInfo = $_POST;
            $productImg = $_FILES;

            $result = $productClass->productAdd($productInfo, $productImg);
        }  

        include_once('inc/admin.header.php');

        if(isset($result["succes"])) {      
            echo '<div class="container" font-family: "Arial Black">';
            echo '<h4> Uw product is toegevoed! </h4>';
            echo '</div>';
        }
    ?>
    <body>
        <div class="container">
            <h1 class="well titel2">Product Toevoegen</h1>
            <div class="well col-xs-12 col-sm-12 col-md-12 col-lg-12"> <!-- grote van achtergrond-->
                <div class="row">
                    <form role="form" method="post" accept-charset="UTF-8" enctype="multipart/form-data"> <!--ingevoerde gegevens van form, worden versuurd in POST en geïncrypt in UTF-8-->

                    <!--Productnaam-->
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"> <!--de kolom wordt hiermee groter of kleiner gemaakt/ xs(mobiel) sm(tablet) md(laptop) lg(groot desk)-->
                        <label for="name">Naam</label> <!--De label for moet hetzelde als de input id zijn om ze met elkaar te verbinden-->
                        <input type="text" name="name" id="name" class="form-control"> <!--met`form-control wordt e-mailadres(tekst) boven de kolom geplaatst-->
                        <div class="errMsg">
                            <?php if(isset($result['name'])){ echo $result['name']; } ?>
                        </div>

                <!--Productbeschrijving-->
                        <label for="description">Beschrijving</label>
                        <textarea name="description" id="description" rows="5"  class="form-control"></textarea> <!--textarea zorgt ervoor dat je meerdere rijen text kunt schrijven-->
                        <!--cols="50" - productfoto gaat 50 omlaag-->
                    </div>

                    <!--Productfoto-->

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <label >Foto</label><br>    
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                            <img data-src="holder.js/100%x100%" src="../assets/images/placeholder.png" alt="...">
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                        <span class="btn btn2 btn-file" style="background-color: #FF1493"><span class="fileinput-new" style="color: white">Select image</span>
                        <span class="fileinput-exists" style="color: white">Change</span><input type="file" name="fileToUpload" id="fileToUpload" accept="image/*"></span>
                        </div>
                        <div class="errMsg">
                            <?php if(isset($result['img'])){ echo $result['img']; } ?>
                        </div>
                    </div>
                    </div>
                                
                    <!--Productprijs-->
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <label for="price">Prijs</label>
                            <div class="inner-addon left-addon">
                                <i class="glyphicon glyphicon-euro"></i>
                                <input type="text" name="price" id="price" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="errMsg">
                        <?php if(isset($result['price'])){ echo $result['price']; } ?>
                    </div>

                    <!--Productaantal-->
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <label for="stock">Aantal</label>
                            <input type="number" name="stock" id="stock" value="1" class="form-control">
                        </div>
                    </div>
                    
                    <!--ProductCat-->
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <label for="category">Categorie</label><br>
                            <select name="category">
                                <?php
                                    $categories = $categoryClass->selectAllCategories();
                                    
                                    foreach($categories as $categorie){
                                       echo '<option value="'.$categorie["id"].'">'.$categorie["name"].'</option>';
                                    }

                                    
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="errMsg">
                        <?php if(isset($result['category'])){ echo $result['category']; } ?>
                    </div>

                    <!--Gegevens opslaan-->
                    <div class="row" style="float: right">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="color: white">
                          <!--  <a href="adminProductOverview.php"> 
                                <input type="submit" name="submitBack" id="submitBack" style="background-color: #FF1493" value="Terug" class="btn">
                            </a> -->
                            <input type="submit" name="submitAddProduct" id="submitAddProduct" style="background-color: #FF1493" value="Product Toevoegen" class="btn">

                        </div>
                    </div>
                        <!--ProductID-->
                        <!--CatogarieID-->
                    </form>
                </div> <!--row-a end-->
            </div> <!--colum end-->
        </div> <!--container end-->
    </body>
</html>
