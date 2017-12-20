<?php
    session_start();
    include_once('inc/head.php');
    include_once('../classes/database.class.php');
    include_once('../classes/user.class.php');
    include_once('../classes/product.class.php');
    include_once('../classes/cart.class.php');
    include_once('../classes/shipping.class.php');
    include_once('../classes/invoice.class.php');

    $shippingClass = new Shipping();
    $productClass = new Product();
    $cartClass = new Cart();

    $products = $productClass->selectAllProducts();

    if(isset($_POST['checkout']))
    {
        $checkoutMsg = $cartClass->checkoutCart($_POST['shipping']);
    }
        
    include_once('inc/header.php');
?>
<body>
    <div class="content-body">
        <div class="vertical-center">           
            <div class="container">  
                <div class="col-md-12">
                    <div class="errMsg">
                        <?php
                            if(isset($checkoutMsg)){
                                echo $checkoutMsg;    
                            }
                        ?>
                    </div>
                    <table id="example" class="table table-striped dt-responsive display" cellspacing="0" width="100%">
                       <thead>
                            <tr>
                                <th>Foto:</th>
                                <th>Naam:</th>  
                                <th>Prijs:</th>
                                <th>Aantal:</th>
                                <th>Totaal prijs:</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(isset($_SESSION["cart"])){
                                    foreach($_SESSION["cart"] as $product_id => $product){  
                                        $productInfo = $productClass->selectSingleProduct($product_id);

                                         echo '<tr>';
                                            echo '<td><img class="cart-img" src="'.$productInfo['path'].$productInfo['filename'].'"></td>';
                                            echo '<td>'.$productInfo["name"].'</td>';
                                            echo '<td>'.($productInfo["price"] / 100).' euro</td>';
                                            echo '<td>'.$product['quantity'].' x</td>';
                                            echo '<td>'.(($productInfo["price"] * $product['quantity']) / 100).' euro</td>';
                                            echo '<form method="post" action="">';
                                        echo '<td><button style="float:right; margin: 5px" type="submit" class="btn btn-xs btn-danger" name="delete" value="Delete"><i class="fa fa-trash"></i></button>&nbsp;<br></td>';
                                            echo '<input type="hidden" name="id" value="'.$productInfo["id"].'"/>';   
                                        echo '</form>';
                                        echo '</tr>';
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <form class="form" role="form" method="post" enctype="multipart/form-data">
                    <div class="col-md-12">
                    <label for="shipping">Verzend methode: </label>
                    <select name="shipping">
                        <?php
                            $shipping = $shippingClass->selectAllShipping();
                                var_dump($categories);
                            foreach($shipping as $methods){
                                echo '<option value="'.$methods["method"].'">'.$methods["method"].' '.($methods["fee"] / 100).' euro</option>';
                            }
                        ?>
                    </select>
                        </div>
                    <div class="col-md-1">
                        <input type="submit" name="checkout" class="btn btn2" value="Bestellen">
                    </div>
                </form>
                <div class="col-md-1">
                    <a href="products.php" class="btn btn2">Verder winkelen</a>
                </div>
            </div>
        </div>
    </div>
    <?php
        include_once('inc/footer.php');
    ?>
</body>
