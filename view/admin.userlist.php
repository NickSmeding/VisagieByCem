
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

    if(ISSET($_POST['verwijder'])){
        $userClass->deleteUser($_POST["id"]);
    }

    $userlist = $userClass->selectAllUsers();

    include_once('inc/admin.header.php');
?>
    <body>
        <div class="container">  
            <h1 class="titel">Accounts</h1>       
            <table id="example1" class="table table-striped dt-responsive display table-condensed" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Naam</th>
                        <th>Adres</th>
                        <th>Postcode</th>
                        <th>Woonplaats</th>
                        <th>Geboortedatum</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach($userlist as $user){   
                            echo '<tr>';
                                echo '<td>'.$user['customerid'].'</td>';
                                echo '<td>'.$user['firstname'].' '.$user['insertion'].' '.$user['lastname'].'</td>';
                                echo '<td>'.$user['street'].' '.$user['housenumber'].'</td>';
                                echo '<td>'.$user['zip'].'</td>';
                                echo '<td>'.$user['city'].'</td>';
                                echo '<td>'.$user['birthdate'].'</td>';
                                echo '<td>'.$user['email'].'</td>';
                                echo '<td>';
                        echo '<a href="admin.usersettings.php?customerid='.$user['customerid'].'" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></a> <button class="btn btn-xs btn-danger deleteUserBtn" data-target="#deleteUser" data-toggle="modal" data-id="'.$user["customerid"].'" data-name="'.$user["firstname"].' '.$user["insertion"].' '.$user["lastname"].'"><i class="fa fa-trash"></i></button></td>';
                        }
                    ?>
                </tbody>
            </table>

             <!--- Popup account verwijderen -->
         <div class="modal fade" id="deleteUser" role="dialog">
    <div class="modal-dialog">
              <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Account verwijderen</h4>
        </div>
        <div class="modal-body">
            <h4 class="well">Weet u zeker dat u het volgende account wilt verwijderen?</h4>
            <p class="well" id="name"></p>
        </div>
        <div class="modal-footer">
           <div class="row">
                        <div class="col-sm-3">
                            <input type="submit" name="back" id="back" class="btn btn-lg btn-info btn-block" data-dismiss="modal" value="Terug">
                        </div>
                        <div class="col-sm-5">
                            <form role="form" method="post" accept-charset="UTF-8" action="admin.userlist.php">
                            <input type="text" name="id" id="id" value="" style="display:none"/>
                            <input type="submit" class="btn btn-lg btn-warning btn-block" role="button" id="verwijder" name="verwijder" value="Verwijder"></form>
                        </div></div>
        </div></div>
        </div>
      </div>
                    </div>
                </body>
             <?php
    include_once('inc/footer.php');
?>
</html>

<!---->