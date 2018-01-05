<html>
    <?php
    session_start();
    include_once('../classes/database.class.php');
    include_once('../classes/user.class.php');
    include_once('../classes/product.class.php');
    include_once('../classes/cart.class.php');
    include_once('../classes/instagram.class.php');
    include_once('../classes/post.class.php');
    include_once('inc/head.php');
    
        if(isset($_POST['addProduct']))
    {
        $productInfo = $_POST;
        $cartClass->cartAdd($productInfo);
    }
    ?>
    <body>
        <?php
        $userClass = new User(); //Maakt verbinding met class user zodat je alle functions kan gebruiken uit user.class.php
        $postClass = new Post();
        $productClass = new Product();
        
        $post = $postClass-> selectAllPost();
        include_once('inc/header.php');
        ?>
        <div class="container">
            <br><h2><b>Nieuwsberichten</b></h2>
            <?php
            foreach ($post as $post) {
                echo '<div class="col-xs-12">';
                echo '<h4>'.ucfirst($post["title"]).'</h4>';
                echo '</div>';
                echo '<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">';
                echo '<p>
                <img src="'.$post["path"].$post['filename'].'" style="height: 100px; width: 150px; padding-right: 10px" align="left">'.$post["content"].'
                </p>';
                echo '</div>';
                echo '<div class="col-xs-12">';
                echo '<p>
                    <span class="glyphicon glyphicon-user"></span>'.$post["firstname"].' '.$post["insertion"].' '.$post["lastname"].'
                </p>';
                echo '</div>';
                }
                ?>
            </div>
            <?php
            include_once('inc/footer.php');
            ?>
    </body>
</html>