<!DOCTYPE html>

<html>
    <head>
        <title>
            Nieuwsbericht toevoegen
        </title>
    </head>
    <?php
        session_start();
        include_once '../classes/database.class.php';
        include_once '../classes/user.class.php';
        include_once '../classes/uploader.class.php';
        include_once '../classes/product.class.php';
        include_once '../classes/category.class.php';
        include_once '../classes/post.class.php';
        include_once 'inc/head.php';

        $userClass = new User();
        $postClass = new Post();
        $productClass = new Product(); //maakt verbinding met product.class
        $categoryClass = new Category();

    if(!$userClass->checkAdmin() || !$userClass->checkHeadAdmin()){                      
        header("Location: ../index.php");
        exit(); 
    }

        if(isset($_POST["submitAddPost"])) {
            $postInfo = $_POST;
            $postImg = $_FILES;

            $result = $postClass->postAdd($postInfo, $postImg);
        }  

        include_once('inc/admin.header.php');

        if(isset($result["succes"])) {      
            echo '<div class="container" font-family: "Arial Black">';
            echo '<h4> Uw nieuwsbericht is toegevoed! </h4>';
            echo '</div>';
        }
    ?>
    <body>
        <div class="container">
            <h1 class="well titel2">Nieuwsbericht Toevoegen</h1>
            <div class="well col-xs-12 col-sm-12 col-md-12 col-lg-12"> <!-- grote van achtergrond-->
                <div class="row">
                    <form role="form" method="post" accept-charset="UTF-8" enctype="multipart/form-data"> <!--ingevoerde gegevens van form, worden versuurd in POST en geïncrypt in UTF-8-->

                    <!--Postnaam-->
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"> <!--de kolom wordt hiermee groter of kleiner gemaakt/ xs(mobiel) sm(tablet) md(laptop) lg(groot desk)-->
                        <label for="title">Titel</label> <!--De label for moet hetzelde als de input id zijn om ze met elkaar te verbinden-->
                        <input type="text" name="title" id="title" class="form-control"> <!--met`form-control wordt e-mailadres(tekst) boven de kolom geplaatst-->
                        <div class="errMsg">
                            <?php if(isset($result['title'])){ echo $result['title']; } ?>
                        </div>

                <!--Postbeschrijving-->
                        <label for="content">Tekst</label>
                        <textarea name="content" id="content" rows="5"  class="form-control"></textarea> <!--textarea zorgt ervoor dat je meerdere rijen text kunt schrijven-->
                        <!--cols="50" - productfoto gaat 50 omlaag-->
                    </div>

                    <!--Postfoto-->

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <label >Foto</label><br>    
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                            <img data-src="holder.js/100%x100%" src="../assets/images/placeholder.png" alt="...">
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                        <span class="btn btn2 btn-file" style="background-color: #FF1493"><span class="fileinput-new" style="color: white">Kies afbeelding</span>
                        <span class="fileinput-exists" style="color: white">Change</span><input type="file" name="fileToUpload" id="fileToUpload" accept="image/*"></span>
                        </div>
                        <div class="errMsg">
                            <?php if(isset($result['img'])){ echo $result['img']; } ?>
                        </div>
                    </div>
                    </div>


                    <!--Gegevens opslaan-->
                    <div class="row" style="float: right">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="color: white">
                          <!--  <a href="adminProductOverview.php"> 
                                <input type="submit" name="submitBack" id="submitBack" style="background-color: #FF1493" value="Terug" class="btn">
                            </a> -->
                            <input type="submit" name="submitAddPost" id="submitAddPost" style="background-color: #FF1493" value="Nieuwsbericht Toevoegen" class="btn">

                        </div>
                    </div>
                        <!--ProductID-->
                        <!--CatogarieID-->
                    </form>
                </div> <!--row-a end-->
            </div> <!--colum end-->
        </div> <!--container end-->
    <?php
            include_once 'inc/footer.php';
        ?>
    </body>
</html>
