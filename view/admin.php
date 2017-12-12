<!DOCTYPE html>
<html>
    <?php
        session_start();
        include_once '../classes/database.class.php';
        include_once '../classes/user.class.php';
        include_once 'inc/head.php';

        $userClass = new User(); //Maakt verbinding met user.class.php 

        if($userClass->checkAdmin()){
            header("Location: admin.homepage.php");
            die();
        }

        if(isset($_POST['submitLogin'])){       
            $email = $_POST['email'];
            $password = $_POST['password'];
            $admin = true;
            $errorMsg = "";

            if ($user_id = $userClass->login($email, $password, $admin)) {
                //logged in
                header("Location: admin.homepage.php");
                die();
            }else {
                $errorMsg = 'Incorrecte gegevens!<br>';
            }
        }  
    ?>
    
    <head>
        <title>Inlog_Admin</title>
    </head>
    <body>
        <div class="container"> <!--The container class adds a 16px left and right padding to any HTML element-->
            <div class="row row-a" >
                <img class="size-me" src="../assets/images/logo_roze.png" alt="logo"> <!--displayed naam voor in css-->
                <!--<h1 class="text-center" >VisagieByCem</h1>-->
                <div class="col-xs-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-offset-4"> <!--alles wat zich in deze div bevindt, word in de output in het midden van de scherm geplaatst.-->
                    <form role="form" method="post" accept-charset="UTF-8"> <!--ingevoerde gegevens van form, worden versuurd in POST en geïncrypt in UTF-8-->
                        
                        <!-- e-mailadres-->
                        <div class="row">
                            <div class="col-xs-8 col-sm-6 col-md-6 col-lg-6 form-group"> <!--de kolom wordt hiermee groter of kleiner gemaakt-->
                                <label for="email" >E-mailadres</label>
                                <input type="email" name="email" id="email" placeholder="Typ hier uw e-mailadres in.." class="form-control"> <!--met`form-control wordt e-mailadres(tekst) boven de kolom geplaatst-->
                            </div>
                        </div>
                        
                        <!-- wachtwoord -->
                        <div class="row">
                            <div class="col-xs-8 col-sm-6 col-md-6 col-lg-6 form-group"><!--xs(mobiel) sm(tablet) md(laptop) lg(groot desk)-->
                                <label for="password">Wachtwoord</label>
                                <input type="password" name="password" id="password" placeholder="Typ hier uw e-mailadres in.." class="form-control">
                            </div>
                        </div>
                        
                        <!--submit inlog-->
                        <div class="row"> <!--Maakt een aparte kolom voor wachtwoord-->
                            <div class="col-xs-8 col-sm-6 col-md-6 col-lg-6 form-group" style="color: white">
                                <input type="submit" name="submitLogin" id="submitLogin" class="btn btn-block" style="background-color: #FF1493" value="Inloggen"> <!--class="btn btn-primary btn-block" is de layout(primary) en size(block) van de submit button-->
                            </div>
                        </div>
                    </form>
                </div> <!--offset end-->
            </div> <!--row end-->
        </div> <!--container end-->
    </body>
</html>