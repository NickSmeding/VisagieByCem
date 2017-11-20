<?php
    session_start();
    include_once('../classes/database.class.php');
    include_once('../classes/user.class.php');

    $userClass = new User();
    
    if($userClass->checkUser()){
        echo 'je bent ingelogd';
        echo '<a href="logout.php">log nu uit!</a>';
    }else{
        if(isset($_POST['submitLogin'])){       
            $email = $_POST['email'];
            $password = $_POST['password'];
            $errorMsg = "";

            if ($user_id = $userClass->login($email, $password)) {
                //logged in
            }else {
                $errorMsg = 'Incorrecte gegevens!<br>';
            }
        }
    ?>
    <html>
        <head>
        </head>
        <body>
            <form class="form" role="form" method="post" accept-charset="UTF-8" id="login-nav">
                <div class="form-group">
                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                     <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="errMsg">
                    <?php if(isset($errorMsg)){ echo $errorMsg; } ?>
                </div>
                <div class="form-group">
                     <input type="submit" name="submitLogin" id="submitLogin" value="Login" class="btn btn2">
                </div>
            </form>
        </body>
    </html>
<?php
    }
?>