<?php
    $userClass = new User();
    $cartClass = new Cart();
    if(isset($_POST['submitLogin'])){       
        $email = $_POST['email'];
        $password = $_POST['password'];
        $admin = false;
        $errorMsg = "";
        
        if ($user_id = $userClass->login($email, $password, $admin)) {
            //logged in
        }else {
            $errorMsg = 'Incorrecte gegevens!<br>';
        }
    }  

    if(isset($_POST['delete'])){ 
        $cartClass->cartDelete($_POST['id']);
    }
?>
<nav class="navbar navbar-default no-border">
    <div class="col-md-12">
    <div class="container-fluid">
        <div class="navbar-header">
            <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="">
                <img class="brand" src="../assets/images/logo_roze.png" alt="visagiebycem">
            </a>
        </div>
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a class="nav cart-btn" data-toggle="dropdown">
                        <div class="icon-wrapper">
                            <i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i>
                            <span class="badge">
                                <?php
                                    if(isset($_SESSION['cart'])){
                                        echo count($_SESSION['cart']);    
                                    }else{
                                        echo '0';   
                                    }
                                ?>
                            </span>
                        </div>
                    </a>
                    <ul class="dropdown-menu">
                        <?php
                            if(isset($_SESSION["cart"])){
                                foreach($_SESSION["cart"] as $product_id => $product){  
                                    
                                    $productInfo = $productClass->selectSingleProduct($product_id);
                                    echo '<form method="post" action="">';
                                    echo '<button style="float:right; margin: 5px" type="submit" class="btn btn-xs btn-danger" name="delete" value="Delete"><i class="fa fa-trash"></i></button>&nbsp;<br>';
                                        echo '<input type="hidden" name="id" value="'.$productInfo["id"].'"/>';   
                                    echo '</form>';
                                    echo '<div class="margin-left-10">';
                                    echo '<p>'.$productInfo["name"].' (x'.$product["quantity"].')</p>';
                                    echo '<p>prijs: '.($productInfo["price"] * $product["quantity"]) / 100 .' euro</p>'; 
                                    echo '</div>';
                                    echo '<li class="divider"></li>';
                                }

                                if (empty($_SESSION["cart"])) {
                                    echo '<div>Er zijn momenteel geen<br> producten gekozen!</div>';
                                }else{
                                    echo '<div>';
                                    echo '<a href="checkout.php" class="btn btn2">Bestellen</a>';
                                    echo '</div>'; 
                                }
                            }else{
                                echo '<div>Er zijn momenteel geen<br> producten gekozen!</div>';
                            }
                        ?>
                    </ul>
                </li>
                <li>
                    <?php 
                            if($userClass->checkUser()){
                                $user = $userClass->getUserData($_SESSION['user_id']);
                                echo '<ul class="nav navbar-nav navbar-right dropdown-button">';
                                echo '<li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>
                                ';
                                echo $user['firstname'].' '.$user['insertion'].' '.$user['lastname'];
                                echo '
                                        </b> <span class="productet"></span></a>
                                        <ul id="login-dp" class="dropdown-menu">
                                            <li>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <a href="inc/logout.php" id="menu-toggle"><i class="fa fa-sign-out  fa-1x menu-toggle" aria-hidden="true"></i>Logout</a><br>
                                                        <a href="usersettings.php" id="menu-toggle"><i class="fa fa-cog"  fa-1x menu-toggle" aria-hidden="true"></i>Verander gegevens</a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>  
                                    </li>
                                ';
                            }else{
                                echo '<ul class="nav navbar-nav navbar-right dropdown-button">';
                                echo'
                                    <li class="dropdown open">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>
                                    Login
                                        </b> <span class="productet"></span></a>
                                        <ul id="login-dp" class="dropdown-menu">
                                            <li>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        Log eerst in! 
                                                        <form class="form" role="form" method="post" accept-charset="UTF-8" id="login-nav">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="email" name="email" placeholder="Gebruikersnaam" required>
                                                            </div>
                                                            <div class="form-group">
                                                                 <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                                            </div>
                                                            <div class="errMsg">
                                                            '; 
                                                            if(isset($errorMsg)){ echo $errorMsg; }
                                                            echo '
                                                            </div>
                                                            <div class="form-group">
                                                                 <input type="submit" name="submitLogin" id="submitLogin" value="Login" class="btn btn2">
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="bottom text-center">
                                                        Nieuw? <a href="register.php"><b>Register</b></a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                ';
                            }
                        ?>
                    </ul>
                </li>
            </ul>
            <ul class="mobile-nav">
                <li>
                lgon
                </li>
            </ul>
        </div>
    </div>
</nav>
<nav class="nav navbar navbar-default custom-style">
    <ul class="nav navbar-nav">
        <li><a href="homepage.php">Home</a></li>
        <li><a href="products.php">Producten</a></li>
        <li><a href="#">Tarieven</a></li>
        <li><a href="#">Instagram</a></li>
        <li><a href="#">Over mij</a></li>
        <li><a href="#">Contact</a></li>
    </ul>
</nav>