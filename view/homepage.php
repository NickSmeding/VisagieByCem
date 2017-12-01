<?php
    session_start();
    include_once('../classes/database.class.php');
    include_once('../classes/user.class.php');
    include_once('../classes/product.class.php');
    include_once('../classes/cart.class.php');
    include_once('../classes/instagram.class.php');
    include_once('inc/head.php');
    include_once('inc/header.php');
    
    $instagramClass = new Instagram();
    $obj = $instagramClass->getImages("6276631180.1677ed0.eff99ec2eb3f4da4abf9f9f8c8b7f8e3", "4");

    $cartClass = new Cart();

    $productClass = new Product();
    $products = $productClass->selectAllProducts();

    if(isset($_POST['addProduct']))
    {
        $productInfo = $_POST;
        $cartClass->cartAdd($productInfo);
    }
?>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <br><h2><b>Instagram <span>foto's</span></b></h2><br>
                <?php
                    foreach ($obj['data'] as $post) {

                        $pic_text = $post['caption']['text'];
                        $pic_link = $post['link'];
                        $pic_like_count = $post['likes']['count'];
                        $pic_comment_count = $post['comments']['count'];
                        $pic_src = str_replace("http://", "https://", $post['images']['standard_resolution']['url']);
                        $pic_created_time = date("F j, Y", $post['caption']['created_time']);
                        $pic_created_time = date("F j, Y", strtotime($pic_created_time . " +1 days"));

                        echo "<div class='col-md-3'>";        
                            echo "<a href='{$pic_link}' target='_blank'>";
                                echo "<img class='img-responsive photo-thumb' src='{$pic_src}' alt='{$pic_text}'>";
                            echo "</a>";
                            echo "<p>";
                                echo "<p>";
                                    echo "<div style='color:#888;'>";
                                        echo "<a href='{$pic_link}' target='_blank'>{$pic_created_time}</a>";
                                    echo "</div>";
                                echo "</p>";
                                echo "<p>{$pic_text}</p>";
                            echo "</p>";
                        echo "</div>";
                    }
                ?>
            </div>
            <div class="col-sm-12">
                <br><h2><b>Meest bekeken <span>producten</span></b></h2><br>
                <?php
                    $i = 0;

                    foreach($products as $product){
                        $price = $product['price'] / 100;

                        echo '<div class="col-md-3 col-xs-3 single-product">';
                            echo '<br><img  class="product-img" src="../'.$product['path'].$product['filename'].'"><br>';
                                echo 'Naam: ';
                                echo $product['name'];
                                echo'<button type="button" class="btn btn2 float-right" id="product-model" data-toggle="modal" data-id="'.$product["id"].'" data-name="'.$product['name'].'" data-price="'.$price.'" data-target="#myModal">Bestellen</button>';
                                echo '<br>';
                                echo '<div class="bottom-single-product">';
                                    echo 'Price: '.$price.' euro '; 
                                echo '</div>';
                        echo '</div>';   

                        if (++$i == 4) break;
                    }
                ?>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
    
      <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Bestellen</h4>
                </div>
                <form class="form" role="form" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <h4 class="modal-title" id="product_name"></h4>
                        <div id="product_price"></div>
                        <input type="text" name="product_id" id="product_id" value="" style="display:none"/>
                        Aantal: <input type="number" name="quantity" id="quantity" min="1" value="1"/>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="addProduct" id="addProduct" value="Toevoegen" class="btn btn2">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>