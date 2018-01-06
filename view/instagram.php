<?php
    session_start();
    include_once('../classes/database.class.php');
    include_once('../classes/user.class.php');
    include_once('../classes/product.class.php');
    include_once('../classes/cart.class.php');
    include_once('../classes/instagram.class.php');
    include_once('inc/head.php');
    
    $instagramClass = new Instagram();
    $obj = $instagramClass->getImages("6276631180.1677ed0.eff99ec2eb3f4da4abf9f9f8c8b7f8e3", "16");

    $productClass = new Product();
    $cartClass = new Cart();
    
    include_once('inc/header.php');
?>
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
                            echo "<img style='min-height: 260px' class='img-responsive photo-thumb' src='{$pic_src}' alt='{$pic_text}'>";
                        echo "</a>";
                        echo "<p>";
                            echo "<p>";
                                echo "<div style='color:#888; min-height'>";
                                    echo "<a href='{$pic_link}' target='_blank'>{$pic_created_time}</a>";
                                echo "</div>";
                            echo "</p>";
                            echo "<p style='min-height: 70px'>{$pic_text}</p>";
                        echo "</p>";
                    echo "</div>";
                }
            ?>
        </div>
    </div>
</div>
<?php
    include_once('inc/footer.php');
?>