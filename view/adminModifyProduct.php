<!DOCTYPE html>

<html>
    <?php
    session_start();
    include_once '../classes/database.class.php';
    include_once '../classes/user.class.php';
    include_once '../classes/product.class.php';
    include_once 'inc/head.php';

    $userClass = new User();
    $productClass = new Product();
    
    //haal id van product op
    $product_id = $productClass->selectSingleProduct($_GET["id"]);
    //moet zelfde naam zijn als in browser 
    
    ?>
    <head>
        <title>adminModifyProduct</title>
        <link rel="stylesheet" type="text/css" href="../assets/css/dana.css">
    </head>
    <body>
        <div class="container">
            <h1 class="well titel2">Product Bewerken</h1>
            <div class="well col-xs-12 col-sm-12 col-md-12 col-lg-12"> <!-- grote van achtergrond-->
                <div class="row">
                    <form role="form" method="post" accept-charset="UTF-8"> <!--ingevoerde gegevens van form, worden versuurd in POST en geïncrypt in UTF-8-->
                        
                        <!--ProductID-->
                        <div class="row">
                            <div class="col-sm-2 form-group">
                                <label for="id">Productnummer</label>
                                <input type="number" class="form-control" id="id" readonly value="" >
                            </div>
                        </div>
                        
                        <!--Productnaam-->
                        <div class="row"> <!--Maakt een aparte kolom voor naam-->
                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8"> <!--de kolom wordt hiermee groter of kleiner gemaakt/ xs(mobiel) sm(tablet) md(laptop) lg(groot desk)-->
                                <label for="name">Naam</label> <!--De label for moet hetzelde als de input id zijn om ze met elkaar te verbinden-->
                                <input type="text" name="name" id="name" class="form-control"> <!--met`form-control wordt e-mailadres(tekst) boven de kolom geplaatst-->
                            </div>
                        </div>

                        <!--Productbeschrijving-->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                <label for="description">Beschrijving</label>
                                <textarea name="description" id="description" rows="6"  class="form-control"></textarea> <!--textarea zorgt ervoor dat je meerdere rijen text kunt schrijven-->
                                <!--cols="50" - productfoto gaat 50 omlaag-->
                            </div>
                        </div>

                        <!--Productfoto-->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                <label for="img">Productfoto</label>
                                <input type="file" name="img" id="img" class="form-control" accept="image/*" onchange="preview_image(event)">
                                <img id="output_image" style="max-width: 300px"/>
                                <script type="text/javascript"> //javascript moet altijd tussen <script> geschreven worden.
                                    function preview_image(event)
                                    {
                                        var reader = new FileReader(); //var geeft een variable aan. 
                                        reader.onload = function ()  // same as reader[onload = function()]. onload=the browser has finished loading the page.
                                        {
                                            var output = document.getElementById('output_image');
                                            output.src = reader.result;
                                        }
                                        reader.readAsDataURL(event.target.files[0]);
                                    }
                                </script>
                            </div>
                        </div>

                        <!--Productprijs-->
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <label for="price">Prijs</label>
                                <input type="text" name="price" id="price" class="form-control">
                            </div>
                        </div>

                        <!--Productaantal-->
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <label for="stock">Aantal</label>
                                <input type="number" name="stock" id="stock" value="1" class="form-control">
                            </div>
                        </div>

                        <!--Product actieveren-->
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="active">
                                    <input type="radio" name="active" id="active"> Actieveren
                                </label>
                            </div>
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
    </body>
</html>
