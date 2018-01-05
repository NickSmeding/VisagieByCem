<?php
session_start();
include_once('../classes/database.class.php');
include_once('../classes/user.class.php');
include_once('../classes/category.class.php');
include_once('inc/head.php');
?>
<html>
    <body>
        <?php
            $userClass = new User(); //Maakt verbinding met class user zodat je alle functions kan gebruiken uit user.class.php
            $categoryClass = new Category(); //Maakt verbinding met class product zodat je alle functions kan gebruiken uit product.class.php

            if (!$userClass->checkAdmin()) {
                header("Location: ../index.php");
                exit();
            }

            if (ISSET($_POST['verwijder'])) {
                $categoryClassClass->deleteCategory($_POST["id"]);
            }

            $result = $categoryClass->selectAllCategories();


            include_once('inc/admin.header.php');
        ?>

        <div class="container">
            <p class="titel">Categorie overzicht</p>
            <table id="example1" class="table table-striped dt-responsive display table-condensed" cellspacing="0" width="100%"> <!--table condendes = voor mobiel gebruik maakt het beeld kleiner-->
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Naam</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <div class="row row-c">
                    <a href="admin.Add.Category.php"> <!--link naar toevoegpagina-->
                        <input type="submit" name="addCategory" id="addProduct" style="color: #FF1493" value="+ categorie toevoegen" class="btn btn-default">
                    </a>
                </div>
                <?php
                foreach ($result as $categorie) {
                    echo '<tr>';
                    echo '<td>' . $categorie['id'] . '</td>';
                    echo '<td>' . $categorie['name'] . '</td>';
                    echo '<td>';
                    echo '<button class="btn btn-xs btn-danger deleteUserBtn" data-target="#delete" data-toggle="modal" data-id="' . $categorie["id"] . $categorie["name"] . '">
                          <i class="fa fa-trash"></i>
                          </button></td>';
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