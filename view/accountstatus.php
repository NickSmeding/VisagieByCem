<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
              <meta charset="UTF-8">
        <title>Account deactiveren/activeren</title>
        
          <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php
        include_once('../classes/database.class.php');
        include_once('../classes/user.class.php');
        include_once('../classes/cart.class.php');
        include_once('inc/head.php');
        include_once('inc/header.php');   
             
        $userClass = new User(); //Maakt verbinding met class user zodat je alle functions kan gebruiken uit user.class.php
        
        $userid = 1; //Om te testen, verander naar 1, anders $user['id']//     
        
        if (isset($_POST['accountstatus'])) {
        $userinfo = $_POST;
        }
        
        $getInformation = new Database();
        $getInformation->query("SELECT * FROM customer JOIN address ON customer.address=address.id WHERE customer.id = :userid");
        $getInformation->bind(":userid", $userid);
        $getInformation->execute();
        $userinfo = $getInformation->single();
        ?>
        
        <div class="container">  
                <div class="col-sm-12">
                    <h3 class="well">U kunt hier alleen uw account deactiveren/activeren. 
                        Als uw account is gedeactiveerd ontvangt u geen e-mails meer en kunt u niet meer alle functionaliteiten van de site gebruiken.
                        Om uw account te verwijderen gelieve contact op te nemen via een contactformulier.</h3>
<div class="col-lg-12 well">
            <form role="form" method="post" action="usersettings.php" accept-charset="UTF-8">
             <div class="row">
                        <div class="col-sm-3 form-group">
                            <input type="submit" name="back" id="back" class="btn btn-lg btn-info btn-block" value="Terug">
                        </div>
                        <div class="col-sm-3 form-group">
                        <input type="submit" class="btn btn-lg btn-warning btn-block" id="status" name="status" value="<?php //Controleer status van account//
                        if($userinfo["active"]==1){
                            echo("Deactiveer account");
                        }else{
                            echo("Activeer account");
                        }
                            ?>">
                        </div></div></form></div></div></div>
        
    </body>
</html>
