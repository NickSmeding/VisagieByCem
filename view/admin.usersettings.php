<?php
    session_start();
    include_once('../classes/database.class.php');
    include_once('../classes/user.class.php');
    include_once('../classes/product.class.php');
    include_once('../classes/cart.class.php');
    include_once('inc/head.php');

    $userClass = new User();

    $productClass = new Product();
    
    if(!$userClass->checkAdmin()){
        header("Location: ../index.php");
        exit(); 
    }

    $adminData = $userClass->getAdminData($_SESSION['admin_id']);
    
     if (isset($_POST['updatesettings'])) {
        $result = $userClass->userUpdateAdmin($_POST, $_POST['customerid']);
        $user = $userClass->getUserData($_POST['customerid']); 
    }
            
if(isset($result['succes'])){ echo $result['succes']; }

    if(isset($_POST['viewcustomer'])){ 
        $user = $userClass->getUserData($_POST['customerid2']); 
    }else if(isset($_GET['customerid'])){ 
        $current = $_GET['customerid'];
        $user = $userClass->getUserData($current);
    }
    

    include_once('inc/admin.header.php');

//benodigde informatie laten zien//
?>
        <div class="container">  
                <div class="col-sm-12">
                        <h1 class="well">Klantgegevens</h1>
                    <div class="col-lg-12 well"> <!-- grote van achtergrond accountgegevens -->
                        <form role="form" method="post" accept-charset="UTF-8">
                        
                            <div class="row">
                            <div class="col-sm-2 form-group">
                                <label for="customerid">Klantnummer</label>
                                <input type="number" class="form-control" name="customerid2" id="customerid2" value=<?php if(isset($_POST['viewcustomer']) || isset($_GET['customerid']) || isset($_POST['updatesettings'])){ echo($user['customerid']); }?>>
                            </div>
                                <div class="col-sm-3 form-group">
                                <label for="viewcustomer"> </label>
                                <input type="submit" class="btn btn-lg btn-info btn-block" name="viewcustomer" id="viewcustomer" value="Bekijk klantgegevens">
                            </div></div>
                        </form>
                        <form role="form" method="post" accept-charset="UTF-8">
                                <input type="hidden" class="form-control" name="customerid" id="customerid" value=<?php if(isset($_POST['viewcustomer']) || isset($_GET['customerid']) || isset($_POST['updatesettings'])){ echo($user['customerid']); }?>>
                            <div class="row">
                            <div class="col-sm-4 form-group"> 
                                <label for="firstname">Voornaam</label>
                                <input required type="text" class="form-control" id="firstname" name="firstname" <?php if($adminData['clearance'] == 0){ echo "readonly"; } ?> value="<?php if(isset($_POST['viewcustomer']) || isset($_GET['customerid']) || isset($_POST['updatesettings'])){ echo($user["firstname"]); }?>"> 
                                <div class="errMsg">
                                    <?php if(isset($result['firstname'])){ echo $result['firstname']; } ?>
                                </div>
                            </div>
                            
                            <div class="col-sm-4 form-group">
                                <label for="insertion">Tussenvoegsel</label>
                                <input type="text" class="form-control" id="insertion" name="insertion" <?php if($adminData['clearance'] == 0){ echo "readonly"; } ?> value="<?php if(isset($_POST['viewcustomer']) || isset($_GET['customerid']) || isset($_POST['updatesettings'])){ echo($user["insertion"]); }?>">
                                <div class="errMsg">
                                    <?php if(isset($result['insertion'])){ echo $result['insertion']; } ?>
                                </div>
                            </div>
                            
                            <div class="col-sm-4 form-group">
                                <label for="lastname">Achternaam</label>
                                <input required type="text" class="form-control" id="lastname" name="lastname" <?php if($adminData['clearance'] == 0){ echo "readonly"; } ?> value="<?php if(isset($_POST['viewcustomer']) || isset($_GET['customerid']) || isset($_POST['updatesettings'])){ echo($user["lastname"]); }?>">
                                <div class="errMsg">
                                    <?php if(isset($result['lastname'])){ echo $result['lastname']; } ?>
                                </div>
                            </div></div>
                            <div class="form-group">
                                <label for="email">E-mailadres</label>
                                <input required type="email" class="form-control" id="email" name="email" <?php if($adminData['clearance'] == 0){ echo "readonly"; } ?> value="<?php if(isset($_POST['viewcustomer']) || isset($_GET['customerid']) || isset($_POST['updatesettings'])){ echo($user["email"]); }?>">
                                <div class="errMsg">
                                    <?php if(isset($result['e-mail'])){ echo $result['e-mail']; } ?>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-sm-4 form-group">
                                <label for="phone">Telefoonnummer</label>
                                <input required type="text" class="form-control" id="phone" name="phone" <?php if($adminData['clearance'] == 0){ echo "readonly"; } ?> value="<?php if(isset($_POST['viewcustomer']) || isset($_GET['customerid']) || isset($_POST['updatesettings'])){ echo($user["phone"]); }?>">
                                <div class="errMsg">
                                    <?php if(isset($result['phone'])){ echo $result['phone']; } ?>
                                </div>
                            </div></div>
                            
                            <div class="row">
                            <div class="col-sm-4 form-group">
                                <label for="birthdate">Geboortedatum</label>
                                <input required type="date" class="form-control" id="birthdate" name="birthdate" <?php if($adminData['clearance'] == 0){ echo "readonly"; } ?> value="<?php if(isset($_POST['viewcustomer']) || isset($_GET['customerid']) || isset($_POST['updatesettings'])){ echo($user["birthdate"]); }?>">
                                <div class="errMsg">
                                    <?php if(isset($result['birthdate'])){ echo $result['birthdate']; } ?>
                                </div>
                            </div></div>
                            
                            <div class="row">
                            <div class="col-sm-4 form-group">
                            <label for="city">Woonplaats</label>
                            <input required type="text" class="form-control" id="city" name="city" <?php if($adminData['clearance'] == 0){ echo "readonly"; } ?> value="<?php if(isset($_POST['viewcustomer']) || isset($_GET['customerid']) || isset($_POST['updatesettings'])){ echo($user["city"]); }?>">
                            <div class="errMsg">
                                <?php if(isset($result['city'])){ echo $result['city']; } ?>
                            </div>
                        </div>
                            
                            <div class="col-sm-2 form-group">
                            <label for="zip">Postcode</label>
                            <input required type="text" class="form-control" id="zip" name="zip" <?php if($adminData['clearance'] == 0){ echo "readonly"; } ?> value='<?php if(isset($_POST['viewcustomer']) || isset($_GET['customerid']) || isset($_POST['updatesettings'])){ echo($user["zip"]); }?>'>
                            <div class="errMsg">
                                <?php if(isset($result['zip'])){ echo $result['zip']; } ?>
                            </div>
                        </div>
                            </div> 
                            <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for="street">Straatnaam</label>
                        <input required type="text" class="form-control" id="street" name="street" <?php if($adminData['clearance'] == 0){ echo "readonly"; } ?> value="<?php if(isset($_POST['viewcustomer']) || isset($_GET['customerid']) || isset($_POST['updatesettings'])){ echo($user["street"]); }?>">
                        <div class="errMsg">
                            <?php if(isset($result['street'])){ echo $result['street']; } ?>
                        </div>
                    </div>
                        <div class="col-sm-2 form-group">
                            <label for="housenumber">Huisnummer</label>
                            <input required type="number" class="form-control" id="housenumber" name="housenumber" <?php if($adminData['clearance'] == 0){ echo "readonly"; } ?> value=<?php if(isset($_POST['viewcustomer']) || isset($_GET['customerid']) || isset($_POST['updatesettings'])){ echo($user["housenumber"]); }?>>
                            <div class="errMsg">
                                <?php if(isset($result['housenumber'])){ echo $result['housenumber']; } ?>
                            </div>
                        </div>
                        <div class="col-sm-2 form-group">
                            <label for="extension">Toevoeging</label>
                            <input type="text" class="form-control" id="extension" name="extension" <?php if($adminData['clearance'] == 0){ echo "readonly"; } ?> value="<?php if(isset($_POST['viewcustomer']) || isset($_GET['customerid']) || isset($_POST['updatesettings'])){ echo($user["extension"]); }?>">
                            <div class="errMsg">
                                <?php if(isset($result['extension'])){ echo $result['extension']; } ?>
                            </div>
                        </div></div>
                            <div class="row">
                        <div class="col-sm-3 form-group">
                            <label for="activation">Activatiecode</label><a href="#" data-toggle="popover" data-html="true" data-trigger="hover" data-content="0 is geblokkeerd. </br>1 is gedeactiveerd. </br>2 is actief."><label>?</label></a>
                            <input required type="number" class="form-control" id="active" name="active" min="0" max="2" <?php if($adminData['clearance'] == 0){ echo "readonly"; } ?> value="<?php if(isset($_POST['viewcustomer']) || isset($_GET['customerid']) || isset($_POST['updatesettings'])){ echo($user["active"]); }?>">
                        <div class="errMsg">
                                <?php if(isset($result['active'])){ echo $result['active']; } ?>
                            </div></div></div>
                            <div class="row">
                        <div class="col-sm-3 form-group">
                            <a href="admin.userlist.php"><input type="button" name="back" id="back" class="btn btn-lg btn-info btn-block" value="Terug naar lijst"></a>
                        </div> <div class="col-sm-3 form-group">
                            <input type="submit" name="updatesettings" id="updatesettings" class="btn btn-lg btn-info btn-block" value="Wijzig klantgegevens" <?php if($adminData['clearance'] == 0){ echo("disabled");} ?>>
                        </div>
                                
                        
                        </div></form>
                    </div>
                </div>
            
        
<?php
    include_once('inc/footer.php');
?>
    </body>
    
</html>
