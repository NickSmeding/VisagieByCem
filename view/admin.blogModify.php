<?php
    session_start();
    include_once('../classes/database.class.php');
    include_once('../classes/user.class.php');
    include_once('../classes/product.class.php');
    include_once('../classes/cart.class.php');
    include_once('inc/head.php');
    include_once('../classes/post.class.php');

    $userClass = new User();
    $postClass = new Post();
    $productClass = new Product();
    
    if(!$userClass->checkAdmin() || !$userClass->checkHeadAdmin()){                      
        header("Location: ../index.php");
        exit(); 
    }

    
     if (isset($_POST['updateblog'])) {
        $result = $postClass->updatePost($_POST, $_GET['postid']);
        $post = $postClass->selectPost($_POST['postid']); 
    }
            
if(isset($result['succes'])){ echo $result['succes']; }

if(isset($_GET['postid'])){ 
        $current = $_GET['postid'];
        $post = $postClass->selectPost($current);
    }else{
        header("Location: ../view/admin.blog.php");
    }

    include_once('inc/admin.header.php');

//benodigde informatie laten zien//
?>
         <head>
        <title>Nieuwsbericht bewerken</title>
        <link rel="stylesheet" type="text/css" href="../assets/css/dana.css">
    </head>
    <body>
        <div class="container">
            <h1 class="well titel2">Nieuwsbericht Bewerken</h1>
            <div class="well col-xs-12 col-sm-12 col-md-12 col-lg-12"> <!-- grote van achtergrond-->
                <div class="row">
                    <form role="form" method="post" accept-charset="UTF-8"> <!--ingevoerde gegevens van form, worden versuurd in POST en geïncrypt in UTF-8-->
                        
                        <!--ProductID-->
                        <div class="row">
                            <div class="col-sm-2 form-group">
                                <label for="id">ID</label>
                                <input type="number" class="form-control" name="postid" id="postid" readonly value=<?php echo($post['postid']); ?>>
                            </div>
                        </div>
                        
                        <!--Productnaam-->
                        <div class="row"> <!--Maakt een aparte kolom voor naam-->
                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8"> <!--de kolom wordt hiermee groter of kleiner gemaakt/ xs(mobiel) sm(tablet) md(laptop) lg(groot desk)-->
                                <label for="name">Titel</label> <!--De label for moet hetzelde als de input id zijn om ze met elkaar te verbinden-->
                                <input type="text" name="title" id="title" class="form-control" value="<?php echo($post['title']); ?>"> <!--met`form-control wordt e-mailadres(tekst) boven de kolom geplaatst-->
                            </div>
                        </div>

                        <!--Productbeschrijving-->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                <label for="description">Tekst</label>
                                <textarea name="content" id="content" rows="6"  class="form-control"><?php echo($post['content']); ?></textarea> <!--textarea zorgt ervoor dat je meerdere rijen text kunt schrijven-->
                                <!--cols="50" - productfoto gaat 50 omlaag-->
                            </div>
                        </div>

                        <!--Productfoto-->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                <label for="img">Foto</label>
                                <input type="file" name="img" id="img" class="form-control" accept="image/*" onchange="preview_image(event)">
                                <img id="output_image" style="max-width: 300px"/>
                                <script type="text/javascript"> //javascript moet altijd tussen <script> geschreven worden.
                                    function preview_image(event)
                                    {
                                        var reader = new FileReader(); //var geeft een variable aan. 
                                        reader.onload = function ()  // same as reader[onload = function()]. onload=the browser has finished loading the page.
                                        {
                                            var output = document.getElementById('output_image');
                                            output.src = reader.result;
                                        }
                                        reader.readAsDataURL(event.target.files[0]);
                                    }
                                </script>
                            </div>
                        </div>

                        <!--Gegevens opslaan-->
                        <div class="row" style="float: right">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="color: white">
                                  <a style="color: white" href="admin.blog.php"> 
                                      <input type="button" name="submitBack" id="submitBack" style="background-color: #FF1493" value="Terug" class="btn">
                                  </a> 
                                <a style="color: white" href="admin.blogModify.php?postid=<?php echo $post['postid']; ?>">
                                <input type="submit" name="updateblog" id="updateblog" style="background-color: #FF1493" value="Nieuwsbericht Bewerken" class="btn">
                                </a>
                            </div>
                        </div>
                        <!--ProductID-->
                        <!--CatogarieID-->
                    </form>
                </div> <!--row-a end-->
            </div> <!--colum end-->
        </div> <!--container end-->
            
        
<?php
    include_once('inc/footer.php');
?>
    </body>
    
</html>
