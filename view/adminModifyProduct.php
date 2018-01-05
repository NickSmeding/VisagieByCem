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
        $productClass = new Product();
        $categoryClass = new Category();

        if(!$userClass->checkAdmin()){
            header("Location: ../index.php");
            exit();
        }

        //haal id van product op

        if(!($product = $productClass->selectSingleProduct($_GET["productid"]))){
            header("Location: admin.php");
            exit();   
        }

        if(isset($_POST["submitModifyProduct"])) {
            $productInfo = $_POST;
            $productImg = $_FILES;

            $result = $productClass->productUpdate($productInfo, $productImg);
        }  
        //moet zelfde naam zijn als in browser 

        include_once 'inc/admin.header.php';
    ?>
    <head>
        <title>adminModifyProduct</title>
    </head>
    <body>
        <div class="container">
            <h1 class="well titel2">Product Bewerken</h1>
            <div class="well col-xs-12 col-sm-12 col-md-12 col-lg-12"> <!-- grote van achtergrond-->
                <div class="row">
                    <form role="form" method="post" accept-charset="UTF-8" enctype="multipart/form-data"> <!--ingevoerde gegevens van form, worden versuurd in POST en geïncrypt in UTF-8-->
                        
                        <!--ProductID-->
                        <div class="row">
                            <div class="col-sm-2 form-group">
                                <label for="id">Productnummer</label>
                                <input type="number" class="form-control" name="id" id="id" readonly value="<?php echo $product['id'] ?>">
                            </div>
                        </div>
                        
                        <!--Productnaam-->
                        <div class="row"> <!--Maakt een aparte kolom voor naam-->
                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"> <!--de kolom wordt hiermee groter of kleiner gemaakt/ xs(mobiel) sm(tablet) md(laptop) lg(groot desk)-->
                                <label for="name">Naam</label> <!--De label for moet hetzelde als de input id zijn om ze met elkaar te verbinden-->
                                <input type="text" name="name" id="name" class="form-control" value="<?php echo $product['name'] ?>"> <!--met`form-control wordt e-mailadres(tekst) boven de kolom geplaatst-->
                                <div class="errMsg">
                                <?php if(isset($result['name'])){ echo $result['name']; } ?>
                            </div>
                        

                                <!--Productbeschrijving-->
                                <label for="description">Beschrijving</label>
                                <textarea name="description" id="description" rows="6"  class="form-control"><?php echo $product['description'] ?></textarea> <!--textarea zorgt ervoor dat je meerdere rijen text kunt schrijven-->
                                <!--cols="50" - productfoto gaat 50 omlaag-->
                            </div>
                        

                            <!--Productfoto-->
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <label >Foto</label><br>    
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                        <img data-src="holder.js/100%x100%" src="<?php echo $product['path'].$product['filename']; ?>" alt="...">
                                    </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div><br>
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
                                    <input type="text" name="price" id="price" class="form-control" value="<?php echo $product['price'] / 100 ?>">
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
                                <input type="number" name="stock" id="stock" class="form-control" value="<?php echo $product['stock'] ?>">
                            </div>
                        </div>
                        <div class="errMsg">
                            <?php if(isset($result['stock'])){ echo $result['stock']; } ?>
                        </div>
                        
                        <!--ProductCat-->
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <label for="category">Categorie</label><br>
                                <select name="category">
                                    <?php
                                        $categories = $categoryClass->selectAllCategories();
                                        $current = $product['category'];

                                        foreach($categories as $categorie){
                                           if ($current == $categorie["id"]) {
                                               $selected = 'selected';
                                           } else {
                                               $selected = '';
                                           }
                                            
                                           echo '<option '.$selected.' value="'.$categorie["id"].'">'.$categorie["name"].'</option>';
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
                                <input type="submit" name="submitModifyProduct" id="submitModifyProduct" style="background-color: #FF1493" value="Product Bewerken" class="btn">

                            </div>
                        </div>
                        <!--ProductID-->
                        <!--CatogarieID-->
                    </form>
                </div> <!--row-a end-->
            </div> <!--colum end-->
        </div> <!--container end-->
        <?php
            include_once('inc/footer.php');
        ?>
    </body>
</html>
