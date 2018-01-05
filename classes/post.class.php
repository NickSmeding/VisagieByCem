<?php

//-----
class Post {

    public function __construct() {
        
    }

    public function selectAllPost() {
        $selectAllPost = new Database();
        $selectAllPost->query("SELECT post.id AS postid, post.title AS title, post.content AS content, firstname, insertion, lastname, image.path AS path, image.date AS date, image.filename AS filename FROM post INNER JOIN image ON post.img = image.id INNER JOIN employee ON post.author = employee.id ORDER BY postid DESC");
        $selectAllPost->execute();
        $post = $selectAllPost->resultset();

        return $post;
    }

    
        public function selectPost($currentid) {
        $selectPost = new Database();
        $selectPost->query("SELECT post.id AS postid, post.title AS title, post.content AS content, firstname, insertion, lastname, image.path AS path, image.date AS date, image.filename AS filename FROM post INNER JOIN image ON post.img = image.id INNER JOIN employee ON post.author = employee.id WHERE post.id = :poid");
        $selectPost->bind(":poid", $currentid);
        $selectPost->execute();
        $post = $selectPost->single();

        return $post;
    }
    
    //een nieuwsbericht toevoegen
    public function postAdd($postInfo, $postImg) {
        $error = array();
        $handle = true;

        //kijk of een van deze velden leeg is zoja geef error
        if ("" == trim($postInfo['title'])) {
            $error['title'] = "De titel kan niet leeg zijn!";
            $handle = false;
        }if ("" == trim($postInfo['content'])) {
            $error['content'] = "Tekst is verplicht!";
            $handle = false;
        }

        //als handle niet false is ga dan dit uitvoeren
        if ($handle == true) {
            //als er een foto is opgegeven upload die foto dan met gegeven gegevens
            if (!empty($postImg['fileToUpload']['name'])) {
                $imgUploader = new Uploader();
                $imgUploader->setDestination('../assets/uploads/');
                $imgUploader->setAllowedExtensions(array('image/jpg', 'image/jpeg', 'image/gif', 'image/png'));
                $imgUploader->setFileName($postImg['fileToUpload']['name']);
                $imgUploader->upload($postImg['fileToUpload']);

                //als er een error wordt terug gegevens van Uploader class sla die dan op in error array
                if (!("" == trim($imgUploader->getError()))) {
                    $error['img'] = $imgUploader->getError();
                }
            } else {
                $error['img'] = "U heeft geen foto gekozen!";
            }
        }

        //als er geen errors zijn voer dit dan uit
        if (!$error) {

            //maak nieuw img
            $newImg = new Database();
            $newImg->query("INSERT INTO image (path, date, filename) VALUES (:path, :date, :filename)");
            $newImg->bind(":path", "../assets/uploads/");
            $newImg->bind(":date", date("Y-m-d"));
            $newImg->bind(":filename", $postImg['fileToUpload']['name']);
            $newImg->execute();

            $imgID = $newImg->lastInsertedId();

            if (isset($imgID)) {

                //voeg nieuw Post toe aan database
                $addPost = new Database();
                $addPost->query("INSERT INTO Post(title, content, author, img) VALUES (:title, :content, :author, :img)");
                $addPost->bind(":title", $postInfo['title']);
                $addPost->bind(":content", $postInfo['content']);
                $addPost->bind(":author", $_SESSION['admin_id']);
                $addPost->bind(":img", $imgID);
                $addPost->execute();

                $result['succes'] = 'succes';
                return $result;
                //redirect naar admin.blog.php
                //header("location: adminPostOverview.php");
                //die();
            } else {
                $error['imgUpload'] = "Er is een fout opgetreden bij het toevoegen van de foto!";
            }
        } else {
            return $error;
        }
    }
    
   public function updatePost($postinfo, $postImg)
        { 
            $errorMsg = array();
            $handle = true;
            $post = $this->selectPost($postinfo['postid']);
            
            //validatie voor opgegeven gegevens
            if("" == trim($postinfo['title'])){
                $errorMsg['title'] = "Titel is verplicht!";
                $handle = false;
            }if("" == trim($postinfo['content'])){
                $errorMsg['content'] = "Bericht is verplicht!";
                $handle = false;
            }

            //controleer of er een afbeelding is opgegeven
            if (!empty($postImg['fileToUpload']['name'])) {
                //controleer of deze afbeelding al bestaat in de database
                $checkImg = new Database();
                $checkImg->query('SELECT COUNT * FROM image WHERE filename = :name');
                $checkImg->bind(':name', $postImg['fileToUpload']['name']);
                $checkImg->execute();
                
                $imageExist = $checkImg->single();
                
                if($imageExist==0){
                
                $imgUploader = new Uploader();
                $imgUploader->setDestination('../assets/uploads/');
                $imgUploader->setAllowedExtensions(array('image/jpg', 'image/jpeg', 'image/gif', 'image/png'));
                $imgUploader->setFileName($postImg['fileToUpload']['name']);
                $imgUploader->upload($postImg['fileToUpload']);
                }
                
            }
            
            
            // als handle niet false is en er dus geen errors zijn update dan de post
            if($handle == true){
                
                //update post
                $updatepost = new Database();
                $updatepost->query("UPDATE post SET title = :title, content = :content WHERE id = :postid");
                $updatepost->bind(":title", ucfirst($postinfo['title']));
                $updatepost->bind(":content", $postinfo['content']);
                $updatepost->execute();
                
                $msg['succes'] = "Update is gelukt!";
                return $msg;
                //header("Location: admin.posts.php");
                //exit();
            }else{
                return $errorMsg;
            }
        
        }
    
    //verwijder een nieuwsbericht
        public function deletePost($postid){
            $delete = new Database();
            $delete->query("DELETE FROM post WHERE id=:postid");
            $delete->bind(":postid", $postid);
            $delete->execute();
        }
        

}
?>

