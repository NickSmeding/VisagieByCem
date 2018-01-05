<?php
    session_start();
    include_once('../classes/database.class.php');
    include_once('../classes/user.class.php');
    include_once('../classes/product.class.php');
    include_once('inc/head.php');
?>
<body>
    <?php

        $userClass = new User(); //Maakt verbinding met class user zodat je alle functions kan gebruiken uit user.class.php
        $productClass = new Product(); //Maakt verbinding met class product zodat je alle functions kan gebruiken uit product.class.php

        if(!$userClass->checkAdmin()){
            header("Location: ../index.php");
            exit();
        }
        
        if(ISSET($_POST['verwijder'])){
            $productClass->disableProduct($_POST["id"]);
        }

        $result = $productClass->selectAllProducts();

        include_once('inc/admin.header.php');
    ?>
    <div class="container">
        <p class="titel">Productoverzicht</p>
        <div class="row row-c">
            <a href="adminAddProduct.php"> <!--link naar toevoegpagina-->
                <input type="submit" name="addProduct" id="addProduct" style="color: #FF1493" value="+ product toevoegen" class="btn btn-default">
            </a>
        </div>
        <table id="example1" class="table table-striped dt-responsive display table-condensed" cellspacing="0" width="100%"> <!--table condendes = voor mobiel gebruik maakt het beeld kleiner-->
            <thead>
                <tr>
                    <th>#</th>
                    <th>Img</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Active</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php

                foreach ($result as $product) {
                    echo '<tr>';
                    echo '<td>' . $product['id'] . '</td>';

                    echo '<td>';
                    echo '<img  class="product-img" style="max-width: 200px;" src="'.$product['path'].$product['filename'].'">';

                    echo '<td>' . $product['name'] . '</td>';
                    echo '<td>' . $product['description'] . '</td>';
                    echo '<td>' . $product['catname'] . '</td>';
                    echo '<td>' . $product['stock'] . '</td>';
                    echo '<td>' . $product['price'] / 100 . ' euro</td>';
                    echo '<td>' . $product['active'] . '</td>';
                    echo '<td>';
                    echo '<a href="adminModifyProduct.php?productid='. $product['id'] .'" class="btn btn-xs btn-warning">
                          <i class="fa fa-pencil"></i>
                          </a> 

                          <button class="btn btn-xs btn-danger deleteUserBtn" data-target="#delete" data-toggle="modal" data-id="'.$product["id"].'" data-name="'.$product["name"].'">
                          <i class="fa fa-trash"></i>
                          </button></td>';
                    echo '</tr>';
                }

            ?>
           </tbody>
        </table>
    </div>
    <!--- Popup account verwijderen -->
    <div class="modal fade" id="delete" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Product verwijderen</h4>
                </div>
                <div class="modal-body">
                    <h4 class="well">Weet u zeker dat u het volgende product wilt verwijderen?</h4>
                    <p class="well" id="name"></p>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-sm-3">
                            <input type="submit" name="back" id="back" class="btn btn-lg btn-info btn-block" data-dismiss="modal" value="Terug">
                        </div>
                        <div class="col-sm-5">
                            <form role="form" method="post" accept-charset="UTF-8" action="adminProductOverview.php">
                            <input type="text" name="id" id="id" value="" style="display:none"/>
                            <input type="submit" class="btn btn-lg btn-warning btn-block" role="button" id="verwijder" name="verwijder" value="Verwijder"></form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        include_once 'inc/footer.php';
    ?>
</body>
</html>
