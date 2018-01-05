<?php
    session_start();
    include_once('../classes/database.class.php');
    include_once('../classes/user.class.php');
    include_once('../classes/product.class.php');
    include_once('../classes/cart.class.php');
    include_once('../classes/post.class.php');
    include_once('inc/head.php');

    $userClass = new User();

    $postClass = new Post();

    if(!$userClass->checkAdmin() || !$userClass->checkHeadAdmin()){                      
        header("Location: ../index.php");
        exit(); 
    }

    if(ISSET($_POST['verwijder'])){
        $postClass->deletePost($_POST["id"]);
    }

    $post = $postClass-> selectAllPost();
    
    

    include_once('inc/admin.header.php');
?>
    <body>
        <div class="container">
        <p class="titel">Nieuwsberichten</p>
        <table id="example1" class="table table-striped dt-responsive display table-condensed" cellspacing="0" width="100%"> <!--table condendes = voor mobiel gebruik maakt het beeld kleiner-->
            <thead>
                <tr>
                    <th>#</th>
                    <th>Img</th>
                    <th>Titel</th>
                    <th>Tekst</th>
                    <th>Auteur</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <div class="row row-c">
                <a href="admin.blogAdd.php"> <!--link naar toevoegpagina-->
                    <input type="submit" name="addPost" id="addPost" style="color: #FF1493" value="+ nieuwsbericht toevoegen" class="btn btn-default">
                </a>
            </div>
            <?php

                foreach ($post as $post) {
                    echo '<tr>';
                    echo '<td>' . $post['postid'] . '</td>';

                    echo '<td>';
                    echo '<img  class="product-img" style="max-width: 200px;" src="'.$post['path'].$post['filename'].'">';

                    echo '<td>' . $post['title'] . '</td>';
                    echo '<td>' . $post['content'] . '</td>';
                    echo '<td>' . $post['firstname']." ".$post['insertion']." ".$post['lastname'] . '</td>';
                    echo '<td>';
                    echo '<a href="admin.blogModify.php?postid='. $post['postid'] .'" class="btn btn-xs btn-warning">
                          <i class="fa fa-pencil"></i>
                          </a> 

                          <button class="btn btn-xs btn-danger deleteUserBtn" data-target="#deletePost" data-toggle="modal" data-id="'.$post["postid"].'" data-name="'.$post["title"].'">
                          <i class="fa fa-trash"></i>
                          </button></td>';
                    echo '</tr>';
                }

            ?>
           </tbody>
        </table>
        
                     <!--- Popup nieuwsbericht verwijderen -->
         <div class="modal fade" id="deletePost" role="dialog">
    <div class="modal-dialog">
              <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Account verwijderen</h4>
        </div>
        <div class="modal-body">
            <h4 class="well">Weet u zeker dat u het volgende nieuwsbericht wilt verwijderen?</h4>
            <p class="well" id="name"></p>
        </div>
        <div class="modal-footer">
           <div class="row">
                        <div class="col-sm-3">
                            <input type="submit" name="back" id="back" class="btn btn-lg btn-info btn-block" data-dismiss="modal" value="Terug">
                        </div>
                        <div class="col-sm-5">
                            <form role="form" method="post" accept-charset="UTF-8" action="admin.blog.php">
                            <input type="text" name="id" id="id" value="" style="display:none"/>
                            <input type="submit" class="btn btn-lg btn-warning btn-block" role="button" id="verwijder" name="verwijder" value="Verwijder"></form>
                        </div></div>
        </div></div>
        </div>
      </div>
    </div>
                </body>
             <?php
    include_once('inc/footer.php');
?>
</html>

<!---->