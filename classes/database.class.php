<?php
    class Database{
        private $host = "localhost";
        private $user = "root";
        private $pass = "";
        private $dbname = "";

        private $dbh;
        private $error;
        private $stmt;

        public function __construct(){
            // Het defineren van Data, Source, Name
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname; 
  
            // Nieuwe PDO instance(dbh = DatabaseHandle)
            try{
                $this->dbh = new PDO($dsn, $this->user, $this->pass);
                //command voor debugging
                //$this->dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
            }
            // Het opvangen van errors
            catch(PDOException $e){
                $this->error = $e->getMessage();
            }
        }
    }
?>