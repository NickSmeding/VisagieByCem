<!DOCTYPE html>

<html>
    <?php
    session_start();
    include_once '../classes/database.class.php';
    include_once '../classes/user.class.php';
    include_once '../classes/category.class.php';
    include_once 'inc/head.php';

    $userClass = new User();
    $categoryClass = new Category();

	// Kijkt of de gebruiker admin is
    if (!$userClass->checkAdmin()) {
        header("Location: ../index.php");
        exit();
    }

    //haal id van categorie op

    if (!($category = $categoryClass->selectSingleCategory($_GET["category_id"]))) {
        header("Location: admin.php");
        exit();
    }

    if (isset($_POST["submitModifyCategory"])) {
        $categoryInfo = $_POST;

        $result = $categoryClass->updateCategory($categoryInfo);
    }
    //Het ID wat is de browser staat gebruikt de website

    include_once 'inc/admin.header.php';
    ?>
    <head>
        <link rel="stylesheet" type="text/css" href="../assets/css/dana.css">
    </head>
    <body>
        <div class="container">
            <h1 class="well titel2">Categorie bewerken</h1>
            <div class="well col-xs-12 col-sm-12 col-md-12 col-lg-12"> <!-- grote van achtergrond-->
                <div class="row">
                    <form role="form" method="post" accept-charset="UTF-8"> <!--ingevoerde gegevens van form, worden versuurd in POST en geïncrypt in UTF-8-->

                        <!--CategorieID-->
                        <div class="row">
                            <div class="col-sm-2 form-group">
                                <label for="id">Categorie ID</label>
                                <input type="number" class="form-control" id="id" name="id" readonly value="<?php echo $category['id'] ?>" >
                            </div>
                        </div>

                        <!--Categorienaam-->
                        <div class="row"> <!--Maakt een aparte kolom voor naam-->
                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8"> <!--de kolom wordt hiermee groter of kleiner gemaakt/ xs(mobiel) sm(tablet) md(laptop) lg(groot desk)-->
                                <label for="name">Categorie naam</label> <!--De label for moet hetzelde als de input id zijn om ze met elkaar te verbinden-->
                                <input type="text" name="name" id="name" class="form-control" value="<?php echo $category['name'] ?>"> <!--met`form-control wordt name boven de kolom geplaatst-->
                            </div>
                        </div>
                        <div class="errMsg">
                            <?php
                            if (isset($result['name'])) {
                                echo $result['name'];
                            }
                            ?>
                        </div>
                        <!--Gegevens opslaan-->
                        <div class="row" style="float: right">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="color: white">
                                <input type="submit" name="submitModifyCategory" id="submitModifyCategory" style="background-color: #FF1493" value="Categorie bewerken" class="btn">
                            </div>
                        </div>
                    </form>
                </div> <!--row-a end-->
            </div> <!--colum end-->
        </div> <!--container end-->
    </body>
</html>