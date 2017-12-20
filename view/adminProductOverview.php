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

        $result = $productClass->selectAllProducts();

        include_once('inc/admin.header.php');
    ?>
    <div class="container">
        <p class="titel">Productoverzicht</p>
        <table id="example1" class="table table-striped dt-responsive display table-condensed" cellspacing="0" width="100%"> <!--table condendes = voor mobiel gebruik maakt het beeld kleiner-->
            <thead>
                <tr>
                    <th>#</th>
                    <th>Img</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Active</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <div class="row row-c">
                <a href="adminAddProduct.php"> <!--link naar toevoegpagina-->
                    <input type="submit" name="addProduct" id="addProduct" style="color: #FF1493" value="+ product toevoegen" class="btn btn-default">
                </a>
            </div>
            <?php

                foreach ($result as $product) {
                    echo '<tr>';
                    echo '<td>' . $product['id'] . '</td>';

                    echo '<td>';
                    echo '<img  class="product-img" style="max-width: 200px;" src="'.$product['path'].$product['filename'].'">';

                    echo '<td>' . $product['description'] . '</td>';
                    echo '<td>' . $product['catname'] . '</td>';
                    echo '<td>' . $product['stock'] . '</td>';
                    echo '<td>' . $product['name'] . '</td>';
                    echo '<td>' . $product['price'] . '</td>';
                    echo '<td>' . $product['active'] . '</td>';
                    echo '<td>';
                    echo '<a href="adminModifyProduct.php?productid='. $product['id'] .'" class="btn btn-xs btn-warning">
                          <i class="fa fa-pencil"></i>
                          </a> 

                          <a class="btn btn-xs btn-danger deleteUserBtn" data-target="#myModal4" data-toggle="modal" data-id="'.$product["id"].'" data-name="">
                          <i class="fa fa-trash"></i>
                          </a></td>';
                    echo '</tr>';
                }

            ?>
           </tbody>
        </table>
    </div>
    <?php
        include_once 'inc/footer.php';
    ?>
</body>
</html>
