<header>
    <nav id="custom-bootstrap-menu" class="navbar navbar-custom">
        <div class="container-fluid">
            <div class="col-md-5" style="margin-top:10px">
                <a class="btn color-roze" href="admin.orders.php">Bestellingen</a>
                <a class="btn color-roze" href="admin.userlist.php">Gebruikers</a>
                <a class="btn color-roze" href="adminProductOverview.php">Artikelen</a>
                <a class="btn color-roze" href="admin.categories.php">Categorieën</a>
                <a class="btn color-roze" href="admin.shipping.php">Shipping</a>
                <?php
                    if($userClass->checkHeadAdmin()){                      
                        echo '<a class="btn color-roze" href="admin.adminlist.php">Admins</a>';
                        echo '<a class="btn color-roze" href="admin.blog.php">Blog</a>';
                    }
                ?>
            </div>
            <div class="col-md-2 centered">
                <div class="brand">
                    <img style="width:125px; heigth:75px" src="../assets/images/logo_roze.png"/>
                </div>  
            </div>
            <div class="col-md-5 text-right" style="margin-top:18px">
                <a href="inc/admin.logout.php" id="menu-toggle"><i class="fa fa-sign-out  fa-1x menu-toggle" aria-hidden="true"></i>Logout</a>
            </div>
        </div>
    </nav>
</header>