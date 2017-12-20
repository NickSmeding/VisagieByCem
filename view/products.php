<?php
    session_start();
    include_once('../classes/database.class.php');
    include_once('../classes/user.class.php');
    include_once('../classes/product.class.php');
    include_once('../classes/cart.class.php');
    include_once('inc/head.php');

    $cartClass = new Cart();

    $productClass = new Product();
    $products = $productClass->selectAllProducts();

    if(isset($_POST['addProduct']))
    {
        $productInfo = $_POST;
        $cartClass->cartAdd($productInfo);
    }
    
    include_once('inc/header.php');
?>


<div class="container">
    <div class="row">
        <h1 class="padding-15">Producten</h1>
        <!--<div class="toonSorteerOp">
            Toon: <select>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="40">40</option>
            </select> Sorteer op: <select>
                <option value="prijsOplopend">Prijs oplopend</option>
                <option value="prijsAflopend">Prijs aflopend</option>
            </select>
        </div>
        <br>
        <br>-->
        <body>
            <?php
                foreach($products as $product) {
                    echo "<div class='col-md-6 padding-15'>";
                        echo "<button class='button-nostyle' data-toggle='modal' data-target='#myModal' data-id='".$product["id"]."' data-name='".$product['name']."' data-price='".($product["price"] / 100)."'>";
                            echo "<div class='col-md-12 block'>";
                                echo "<div class='col-md-6'>";
                                    echo "<div class='info'>";
                                        echo ucfirst($product["name"]) . "<br>";
                                    echo "</div>";
                                    echo "<div class='details'>";
                                        echo ucfirst($product["description"]) . "<br>";
                                        echo "€ " . ($product["price"] / 100) . "<br>";
                                        echo "Beschikbaar: ". $product["stock"] . "<br>";
                                    echo "</div>";
                                echo "</div>";
                                echo "<div class='col-md-6 padding-15'>";
                                    echo '<img  class="product-img" src="'.$product['path'].$product['filename'].'">';
                                echo "</div>";
                            echo "</div>";
                        echo "</button>";
                    echo "</div>";
                }
            ?>
            <!--<div class="pagination">
                <a href="#">&laquo;</a>
                <a href="#"class="active">1</a>
                <a href="#" >2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a href="#">5</a>
                <a href="#">6</a>
                <a href="#">&raquo;</a>
            </div>-->
        </body>

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
                            <h4 class="modal-title" id="name"></h4>
                            <div id="product_price"></div>
                            <input type="text" name="product_id" id="id" value="" style="display:none"/>
                            Aantal: <input type="number" name="quantity" id="quantity" min="1" value="1"/>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" name="addProduct" id="addProduct" value="Toevoegen" class="btn btn2">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    include_once('inc/footer.php');
?>