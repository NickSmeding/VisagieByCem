<!DOCTYPE html>

<html>
    <?php
    session_start();
    include_once '../classes/database.class.php';
    include_once '../classes/user.class.php';
    include_once '../classes/shipping.class.php';
    include_once 'inc/head.php';

    $userClass = new User();
    $shippingClass = new Shipping();

	// Kijkt of de gebruiker admin is
    if (!$userClass->checkAdmin()) {
        header("Location: admin.php");
        exit();
    }
	// Stuurt de submit door naar de class category, functie addCategory
    if (isset($_POST["submitAddShipping"])) {
        $shippingInfo = $_POST;

        $result = $shippingClass->addShipping($shippingInfo);
    }

    include_once('inc/admin.header.php');

    if (isset($result["succes"])) {
        echo '<div class="container" font-family: "Arial Black">';
        echo '<h4> shipping methode is toegevoed! </h4>';
        echo '</div>';
    }
    ?>
    <body>
        <div class="container">
            <h1 class="well titel2">Categorie toevoegen</h1>
            <div class="well col-xs-12 col-sm-12 col-md-12 col-lg-12"> <!-- grote van achtergrond-->
                <div class="row">
                    <form role="form" method="post" accept-charset="UTF-8" enctype="multipart/form-data"> <!--ingevoerde gegevens van form, worden versuurd in POST en geïncrypt in UTF-8-->

                        <!--categorytnaam-->
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"> <!--de kolom wordt hiermee groter of kleiner gemaakt/ xs(mobiel) sm(tablet) md(laptop) lg(groot desk)-->
                            <label for="name">Naam Shipping</label> <!--De label for moet hetzelde als de input id zijn om ze met elkaar te verbinden-->
                            <input type="text" name="name" id="name" class="form-control"> <!--met`form-control wordt e-mailadres(tekst) boven de kolom geplaatst-->
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
                                    <input type="submit" name="submitAddShipping" id="submitAddShipping" style="background-color: #FF1493" value="shipping methode toevoegen" class="btn">

                                </div>
                            </div>
                    </form>
                </div> <!--row-a end-->
            </div> <!--colum end-->
        </div> <!--container end-->
    </body>
</html>
