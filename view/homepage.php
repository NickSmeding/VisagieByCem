<?php
    session_start();
    include_once('../classes/database.class.php');
    include_once('../classes/user.class.php');
    include_once('../classes/cart.class.php');
    include_once('../classes/instagram.class.php');
    include_once('inc/head.php');
    include_once('inc/header.php');
    
    $instagramClass = new Instagram();
    $obj = $instagramClass->getImages("6276631180.1677ed0.eff99ec2eb3f4da4abf9f9f8c8b7f8e3", "4");
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
                            echo "<img class='img-responsive photo-thumb' src='{$pic_src}' alt='{$pic_text}'>";
                        echo "</a>";
                        echo "<p>";
                            echo "<p>";
                                echo "<div style='color:#888;'>";
                                    echo "<a href='{$pic_link}' target='_blank'>{$pic_created_time}</a>";
                                echo "</div>";
                            echo "</p>";
                            echo "<p>{$pic_text}</p>";
                        echo "</p>";
                    echo "</div>";
                }
            ?>
        </div>
        <div class="col-sm-12">
            <br><h2><b>Meest bekeken <span>producten</span></b></h2>
        </div>
    </div>
</div>