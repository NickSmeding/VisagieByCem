
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

    if (isset($_POST['status'])){
        $userClass->setStatus($_SESSION['user_id']);
    }

    include_once('inc/header.php');


    if(isset($result['succes'])){ echo $result['succes']; }
//benodigde informatie laten zien en laten aanpassen//
?>
    <body>
        <div class="container">  
                <div class="col-sm-12">
                        <h1 class="titel">Account aanpassen</h1>
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
                                <input required type="text" class="form-control" id="firstname" name="firstname" <?php if($user["active"]==1){ echo("readonly");} ?> value="<?php echo($user["firstname"]); ?>"> 
                                <div class="errMsg">
                                    <?php if(isset($result['firstname'])){ echo $result['firstname']; } ?>
                                </div>
                            </div>
                            
                            <div class="col-sm-4 form-group">
                                <label for="insertion">Tussenvoegsel</label>
                                <input type="text" class="form-control" id="insertion" name="insertion" <?php if($user["active"]==1){ echo("readonly");} ?> value="<?php echo($user["insertion"]); ?>">
                                <div class="errMsg">
                                    <?php if(isset($result['insertion'])){ echo $result['insertion']; } ?>
                                </div>
                            </div>
                            
                            <div class="col-sm-4 form-group">
                                <label for="lastname">Achternaam</label>
                                <input required type="text" class="form-control" id="lastname" name="lastname" <?php if($user["active"]==1){ echo("readonly");} ?> value="<?php echo($user["lastname"]); ?>">
                                <div class="errMsg">
                                    <?php if(isset($result['lastname'])){ echo $result['lastname']; } ?>
                                </div>
                            </div></div>
                            <div class="form-group">
                                <label for="email">emailadres</label>
                                <input required type="email" class="form-control" id="email" name="email" <?php if($user["active"]==1){ echo("readonly");} ?> value="<?php echo($user["email"]); ?>">
                                <div class="errMsg">
                                    <?php if(isset($result['email'])){ echo $result['email']; } ?>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-sm-4 form-group">
                                <label for="phone">Telefoonnummer</label>
                                <input required type="text" class="form-control" id="phone" name="phone" <?php if($user["active"]==1){ echo("readonly");} ?> value="<?php echo($user["phone"]); ?>">
                                <div class="errMsg">
                                    <?php if(isset($result['phone'])){ echo $result['phone']; } ?>
                                </div>
                            </div></div>
                            
                            <div class="row">
                            <div class="col-sm-4 form-group">
                                <label for="birthdate">Geboortedatum</label>
                                <input required type="date" class="form-control" id="birthdate" name="birthdate" <?php if($user["active"]==1){ echo("readonly");} ?> value="<?php echo($user["birthdate"]); ?>">
                                <div class="errMsg">
                                    <?php if(isset($result['birthdate'])){ echo $result['birthdate']; } ?>
                                </div>
                            </div></div>
                            
                            <div class="row">
                            <div class="col-sm-4 form-group">
                            <label for="city">Woonplaats</label>
                            <input required type="text" class="form-control" id="city" name="city" <?php if($user["active"]==1){ echo("readonly");} ?> value="<?php echo($user["city"]); ?>">
                            <div class="errMsg">
                                <?php if(isset($result['city'])){ echo $result['city']; } ?>
                            </div>
                        </div>
                            
                            <div class="col-sm-2 form-group">
                            <label for="zip">Postcode</label>
                            <input required type="text" class="form-control" id="zip" name="zip" <?php if($user["active"]==1){ echo("readonly");} ?> value='<?php echo($user["zip"]) ?>'>
                            <div class="errMsg">
                                <?php if(isset($result['zip'])){ echo $result['zip']; } ?>
                            </div>
                        </div>
                            </div> 
                            <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for="street">Straatnaam</label>
                        <input required type="text" class="form-control" id="street" name="street" <?php if($user["active"]==1){ echo("readonly");} ?> value="<?php echo($user["street"]); ?>">
                        <div class="errMsg">
                            <?php if(isset($result['street'])){ echo $result['street']; } ?>
                        </div>
                    </div>
                        <div class="col-sm-2 form-group">
                            <label for="housenumber">Huisnummer</label>
                            <input required type="number" class="form-control" id="housenumber" name="housenumber" <?php if($user["active"]==1){ echo("readonly");} ?> value=<?php echo($user["housenumber"]); ?>>
                            <div class="errMsg">
                                <?php if(isset($result['housenumber'])){ echo $result['housenumber']; } ?>
                            </div>
                        </div>
                        <div class="col-sm-2 form-group">
                            <label for="extension">Toevoeging</label>
                            <input type="text" class="form-control" id="extension" name="extension" <?php if($user["active"]==1){ echo("readonly");} ?> value="<?php echo($user["extension"]); ?>">
                            <div class="errMsg">
                                <?php if(isset($result['extension'])){ echo $result['extension']; } ?>
                            </div>
                        </div></div>
                        
                        

                        
                        <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="oldpass">Huidig wachtwoord</label>
                            <input required type="password" class="form-control" <?php if($user["active"]==1){ echo("readonly");} ?> name="oldpass" id="oldpass">
                            <div class="errMsg">
                                <?php if(isset($result['oldpass'])){ echo $result['oldpass']; } ?>
                            </div>
                        </div></div>
                        <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="newpass">Nieuw wachtwoord</label>
                            <input type="password" class="form-control" <?php if($user["active"]==1){ echo("readonly");} ?> name="newpass" id="newpass">
                            <div class="errMsg">
                                <?php if(isset($result['newpass'])){ echo $result['newpass']; } ?>
                            </div>
                        </div></div>
                            <div class="row">
                        <div class="col-sm-3 form-group">
                            <input type="submit" name="updatesettings" id="updatesettings" class="btn btn-lg btn-info btn-block" value="Wijzig klantgegevens" <?php if($user["active"]==1){ echo("disabled");} ?>>
                        </div><div class="col-sm-3 form-group">
                            <button type="button" name="accountstatus" id="accountstatus" class="btn btn-lg btn-warning btn-block" data-toggle="modal" data-target="#setStatus"><?php //Controleer status van account//
                        if($user["active"]==2){
                            echo("Deactiveer account");
                        }else{
                            echo("Activeer account");
                        }
                            ?></button>
                             </div></div>
                        </form>
                        </div>
                    </div>
                </div>
            
         <!--- Popup status account -->
         <div class="modal fade" id="setStatus" role="dialog">
    <div class="modal-dialog">
              <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Deactiveren/Activeren</h4>
        </div>
        <div class="modal-body">
          <p class="well">U kunt alleen uw account deactiveren/activeren. 
                        Als uw account is gedeactiveerd ontvangt u geen e-mails meer en kunt u niet meer alle functionaliteiten van de site gebruiken.
                        Om uw account te verwijderen gelieve contact op te nemen via een contactformulier.</p>
        </div>
        <div class="modal-footer">
           <div class="row">
                        <div class="col-sm-3">
                            <input type="submit" name="back" id="back" class="btn btn-lg btn-info btn-block" data-dismiss="modal" value="Terug">
                        </div>
                        <div class="col-sm-5">
                            <form role="form" method="post" accept-charset="UTF-8" action="usersettings.php">
                            <input type="submit" class="btn btn-lg btn-warning btn-block" role="button" id="status" name="status" value="<?php //Controleer status van account//
                        if($user["active"]==2){
                            echo("Deactiveer account");
                        }else{
                            echo("Activeer account");
                        }
                        ?>"></form>
        
                        </div></div>
        </div></div>
        </div>
      </div>


    </body>
</html>
