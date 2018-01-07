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

		
		// kijkt of de gebruiker admin is
        if (!$userClass->checkAdmin()) {
            header("Location: ../index.php");
            exit();
        }
		
		// Stuurt de delete button door naar de class category, functie deleteCategory
        if (ISSET($_POST['deleteCategory'])) {
            $result = $categoryClass->deleteCategory($_POST["id"]);
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
                foreach ($result as $category) {
                    echo '<tr>';
                    echo '<td>' . $category['id'] . '</td>';
                    echo '<td>' . $category['name'] . '</td>';
                    echo '<td>';
                    echo '<a href="admin.Modify.Category.php?category_id=' . $category['id'] . '" class="btn btn-xs btn-warning">
                          <i class="fa fa-pencil"></i>
                          </a>

                          <button class="btn btn-xs btn-danger deleteUserBtn" data-target="#delete" data-toggle="modal" data-id="' . $category["id"] . '" data-name="' . $category["name"] . '">
                          <i class="fa fa-trash"></i>
                          </button></td>';
                    echo '</tr>';
                }
                ?>

                </tbody>
            </table>
            <!--- Popup category verwijderen wanneer je op het kleine verwijderknopje drukt. Deze functie wordt geactiveerd bij het verwijderknopje, daarin staat de regel 'data-toggle="modal"'. Die stuurt het door -->
            <div class="modal fade" id="delete" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Categorie verwijderen</h4>
                        </div>
                        <div class="modal-body">
                            <h4 class="well">Weet u zeker dat u deze categorie wilt verwijderen?</h4>
                            <p class="well" id="name"></p>
                        </div>
                        <div class="modal-footer">
                            <div class="row">
                                <div class="col-sm-3">
                                    <input type="submit" name="back" id="back" class="btn btn-lg btn-info btn-block" data-dismiss="modal" value="Terug">
                                </div>
                                <div class="col-sm-5">
                                    <form role="form" method="post" accept-charset="UTF-8" action="admin.categories.php">
                                        <input type="text" name="id" id="id" value="" style="display:none"/>
                                        <input type="submit" class="btn btn-lg btn-warning btn-block" role="button" id="deleteCategory" name="deleteCategory" value="Verwijder"></form>
                                </div></div>
                        </div></div>
                </div>
            </div>
        </div>
        <?php
            include_once 'inc/footer.php';
        ?>
    </body>
</html>