<?php
session_start();
include_once('../classes/database.class.php');
include_once('../classes/user.class.php');
include_once('../classes/cart.class.php');
include_once('inc/head.php');
include_once('inc/header.php');
?>


<div class="container">
    <div class="row">
        <h1>Shop</h1>
        <div class="toonSorteerOp">
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
        <br>
        <body>
            <?php
            $allProducts = new Database();
            $allProducts->query("SELECT * FROM product");
            $allProducts->execute();
            $products = $allProducts->resultset();
            foreach ($products as $product) {
                echo "<div class='col-sm-6' data-toggle='modal' data-target='#myModal'>";
                echo "<div class='block'>";
                echo "<div class='info'>";
                echo ucfirst($product["name"]) . "<br>";
                echo "</div>";
                echo "<div class='details'>";
                echo ucfirst($product["description"]) . "<br>";
                echo "€ " . $product["price"] . "<br>";
                echo $product["stock"] . "<br>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            ?>
            <div class="pagination">
                <a href="#">&laquo;</a>
                <a href="#"class="active">1</a>
                <a href="#" >2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a href="#">5</a>
                <a href="#">6</a>
                <a href="#">&raquo;</a>
            </div>
        </body>

        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><?php echo ucfirst($product["name"]) ?> </h4>
                    </div>
                    <div class="modal-body">
                        <p><?php echo ucfirst($product["description"]) . "<br>" . "€ " . $product["price"] . "<br>" . $product["stock"] ?> </p>
                        <button class="winkelwagen-knop" >In winkelwagen</button>
                    </div>
                    <br>
                    <br>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
