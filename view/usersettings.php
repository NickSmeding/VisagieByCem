<?php
    session_start();
    include_once('../classes/database.class.php');
    include_once('../classes/user.class.php');
    include_once('../classes/product.class.php');
    include_once('../classes/cart.class.php');
    include_once('inc/head.php');

    $userClass = new User();

    $productClass = new Product();
    
    if(!$userClass->checkUser()){
        header("Location: ../index.php");
        exit(); 
    }

    $user = $userClass->getUserData($_SESSION['user_id']);
    
    if (isset($_POST['updatesettings'])) {
        $result = $userClass->userUpdate($_POST, $_SESSION['user_id']);
    }

    include_once('inc/header.php');
?>
<body>
    <?php    
        //Deactiveer of activeer account
        $getActive = new Database();
        $getActive->query("SELECT active FROM customer WHERE id = :userid");
        $getActive->bind("userid", $user['id']);
        $getActive->execute();
        $userActive = $getActive->single();
        if (isset($_POST['status'])){
            if ($userActive['active'] == 0){
                $activate = new Database();
                $activate->query("UPDATE Customer SET active = 1 WHERE id = :userid");
                $activate->bind("userid", $user['id']);
                $activate->execute();
            }else{
                $deactivate = new Database();
                $deactivate->query("UPDATE Customer SET active = 0 WHERE id = :userid");
                $deactivate->bind("userid", $user['id']);
                $deactivate->execute();
            }
        }

        if(isset($result['succes'])){ echo $result['succes']; }
        //benodigde informatie laten zien en laten aanpassen//
        ?>
        <div class="container">  
                <div class="col-sm-12">
                        <h1 class="well">Account aanpassen</h1>
                    <div class="col-lg-12 well"> <!-- grote van achtergrond accountgegevens -->
                        <form role="form" method="post" accept-charset="UTF-8">
                        
                            <div class="row">
                            <div class="col-sm-2 form-group">
                                <label for="userid">Klantnummer</label>
                                <input type="number" class="form-control" id="userid" readonly value=<?php echo($_SESSION['user_id']); ?>>
                            </div></div>
                            <div class="row">
                            <div class="col-sm-4 form-group">
                                <label for="firstname">Voornaam</label>
                                <input required type="text" class="form-control" id="firstname" name="firstname" <?php if($user["active"]==0){ echo("readonly");} ?> value="<?php echo($user["firstname"]); ?>"> 
                                <div class="errMsg">
                                    <?php if(isset($result['firstname'])){ echo $result['firstname']; } ?>
                                </div>
                            </div>
                            
                            <div class="col-sm-4 form-group">
                                <label for="insertion">Tussenvoegsel</label>
                                <input type="text" class="form-control" id="insertion" name="insertion" <?php if($user["active"]==0){ echo("readonly");} ?> value="<?php echo($user["insertion"]); ?>">
                                <div class="errMsg">
                                    <?php if(isset($result['insertion'])){ echo $result['insertion']; } ?>
                                </div>
                            </div>
                            
                            <div class="col-sm-4 form-group">
                                <label for="lastname">Achternaam</label>
                                <input required type="text" class="form-control" id="lastname" name="lastname" <?php if($user["active"]==0){ echo("readonly");} ?> value="<?php echo($user["lastname"]); ?>">
                                <div class="errMsg">
                                    <?php if(isset($result['lastname'])){ echo $result['lastname']; } ?>
                                </div>
                            </div></div>
                            <div class="form-group">
                                <label for="e-mail">E-mailadres</label>
                                <input required type="email" class="form-control" id="e-mail" name="e-mail" <?php if($user["active"]==0){ echo("readonly");} ?> value="<?php echo($user["email"]); ?>">
                                <div class="errMsg">
                                    <?php if(isset($result['e-mail'])){ echo $result['e-mail']; } ?>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-sm-4 form-group">
                                <label for="phone">Telefoonnummer</label>
                                <input required type="text" class="form-control" id="phone" name="phone" <?php if($user["active"]==0){ echo("readonly");} ?> value="<?php echo($user["phone"]); ?>">
                                <div class="errMsg">
                                    <?php if(isset($result['phone'])){ echo $result['phone']; } ?>
                                </div>
                            </div></div>
                            
                            <div class="row">
                            <div class="col-sm-4 form-group">
                                <label for="birthdate">Geboortedatum</label>
                                <input required type="date" class="form-control" id="birthdate" name="birthdate" <?php if($user["active"]==0){ echo("readonly");} ?> value="<?php echo($user["birthdate"]); ?>">
                                <div class="errMsg">
                                    <?php if(isset($result['birthdate'])){ echo $result['birthdate']; } ?>
                                </div>
                            </div></div>
                            
                            <div class="row">
                            <div class="col-sm-4 form-group">
                            <label for="city">Woonplaats</label>
                            <input required type="text" class="form-control" id="city" name="city" <?php if($user["active"]==0){ echo("readonly");} ?> value="<?php echo($user["city"]); ?>">
                            <div class="errMsg">
                                <?php if(isset($result['city'])){ echo $result['city']; } ?>
                            </div>
                        </div>
                            
                            <div class="col-sm-2 form-group">
                            <label for="zip">Postcode</label>
                            <input required type="text" class="form-control" id="zip" name="zip" <?php if($user["active"]==0){ echo("readonly");} ?> value='<?php echo($user["zip"]) ?>'>
                            <div class="errMsg">
                                <?php if(isset($result['zip'])){ echo $result['zip']; } ?>
                            </div>
                        </div>
                            </div> 
                            <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for="street">Straatnaam</label>
                        <input required type="text" class="form-control" id="street" name="street" <?php if($user["active"]==0){ echo("readonly");} ?> value="<?php echo($user["street"]); ?>">
                        <div class="errMsg">
                            <?php if(isset($result['street'])){ echo $result['street']; } ?>
                        </div>
                    </div>
                        <div class="col-sm-2 form-group">
                            <label for="housenumber">Huisnummer</label>
                            <input required type="number" class="form-control" id="housenumber" name="housenumber" <?php if($user["active"]==0){ echo("readonly");} ?> value=<?php echo($user["housenumber"]); ?>>
                            <div class="errMsg">
                                <?php if(isset($result['housenumber'])){ echo $result['housenumber']; } ?>
                            </div>
                        </div>
                        <div class="col-sm-2 form-group">
                            <label for="extension">Toevoeging</label>
                            <input type="text" class="form-control" id="extension" name="extension" <?php if($user["active"]==0){ echo("readonly");} ?> value="<?php echo($user["extension"]); ?>">
                            <div class="errMsg">
                                <?php if(isset($result['extension'])){ echo $result['extension']; } ?>
                            </div>
                        </div></div>
                        
                        

                        
                        <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="oldpass">Huidig wachtwoord</label>
                            <input required type="password" class="form-control" <?php if($user["active"]==0){ echo("readonly");} ?> name="oldpass" id="oldpass">
                            <div class="errMsg">
                                <?php if(isset($result['oldpass'])){ echo $result['oldpass']; } ?>
                            </div>
                        </div></div>
                        <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="newpass">Nieuw wachtwoord</label>
                            <input type="password" class="form-control" <?php if($user["active"]==0){ echo("readonly");} ?> name="newpass" id="newpass">
                            <div class="errMsg">
                                <?php if(isset($result['newpass'])){ echo $result['newpass']; } ?>
                            </div>
                        </div></div>
                            <div class="row">
                        <div class="col-sm-3 form-group">
                            <input type="submit" name="updatesettings" id="updatesettings" class="btn btn-lg btn-info btn-block" value="Wijzig klantgegevens" <?php if($user["active"]==0){ echo("disabled");} ?>>
                        </div><div class="col-sm-3 form-group"></form><form role="form" action="accountstatus.php" method="post" accept-charset="UTF-8">
                            <input type="submit" name="accountstatus" id="accountstatus" class="btn btn-lg btn-warning btn-block" value="<?php //Controleer status van account//
                        if($user["active"]==1){
                            echo("Deactiveer account");
                        }else{
                            echo("Activeer account");
                        }
                            ?>"> </div></div>
                        </form>
                        </div>
                    </div>
                </div>
            
        

    </body>
</html>
