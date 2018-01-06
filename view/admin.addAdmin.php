<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Administrator toevoegen</title>
    </head>
    
        
        <?php
   session_start();
    include_once('../classes/database.class.php');
    include_once('../classes/user.class.php');
    include_once('../classes/product.class.php');
    include_once('../classes/cart.class.php');
    include_once('inc/head.php');

    $userClass = new User();

    $productClass = new Product();
    
    if(!$userClass->checkAdmin() || !$userClass->checkHeadAdmin()){
        header("Location: ../index.php");
        exit(); 
    }

    
    if(isset($_POST['submitRegister'])){
        
        $result = $userClass->registerAdmin($_POST);

    }
    

    include_once('inc/admin.header.php');
        ?>
    <body>
    <div class="container">
        <h1 class="well">Administrator-account aanmaken</h1>
        <div class="col-lg-12 well"> <!-- grote van achtergrond accountgegevens -->

            <div class="row">
                <h3 class="well-sm">Account gegevens</h3>
                <form role="form" method="post" accept-charset="UTF-8"> <!-- From, alle gegevens die worden ingevoerd in form. worden verstuurd in de POST (geïncrypt in UTF-8) (stap 1) -->

                    <div class="col-sm-12"> <!-- Breedte van form -->

                        <!-- Voornaam, tussenvoegsel en achternaam-->
                        <div class="row">
                            <div class="col-sm-4 form-group">
                                <label for="firstName">Voornaam</label>
                                <input type="text" id="firstName" name="firstName" class="form-control" required value="<?php if(isset($userInfo["firstName"])){echo($userInfo["firstName"]);} ?>">
                                <div class="errMsg">
                                    <?php if(isset($result['firstName'])){ echo $result['firstName']; } ?>
                                </div>
                            </div>
                            <div class="col-sm-4 form-group">
                                <label for="insertion">Tussenvoegsel</label>
                                <input type="text" id="insertion" name="insertion" class="form-control" value="<?php if(isset($userInfo["email"])){echo($userInfo["email"]);} ?>">
                                <div class="errMsg">
                                    <?php if(isset($result['insertion'])){ echo $result['insertion']; } ?>
                                </div>
                            </div>
                            <div class="col-sm-4 form-group">
                                <label for="lastName">Achternaam</label>
                                <input type="text" id="lastName" name="lastName" class="form-control" required value="<?php if(isset($userInfo["lastName"])){echo($userInfo["lastName"]);} ?>">
                                <div class="errMsg">
                                    <?php if(isset($result['lastName'])){ echo $result['lastName']; } ?>
                                </div>
                            </div>
                        </div>

                        <!--E-mailadres-->
                        <div class="form-group">
                            <label for="email">E-mailadres</label>
                            <input type="email" id="email" name="email" class="form-control" required value="<?php if(isset($userInfo["email"])){echo($userInfo["email"]);} ?>">
                            <div class="errMsg">
                                <?php if(isset($result['email'])){ echo $result['email']; } ?>
                            </div>
                        </div>

                        <!--Wachtwoord-->
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="password">Wachtwoord</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                                <div class="errMsg">
                                    <?php if(isset($result['password'])){ echo $result['password']; } ?>
                                </div>
                            </div>
                        </div>

                            
                        <input type="submit" name="submitRegister" id="submitRegister" class="btn btn-lg btn-info" value="Registeren"> <!-- submit alle gegevens naar de POST (stap 2) -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
