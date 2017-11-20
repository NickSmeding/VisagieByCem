<?php
    class Database{
        private $host = "localhost";
        private $user = "root";
        private $pass = "";
        private $dbname = "visagie_by_cem";

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
        
        //query klaar zetten
        public function query($query){
            $this->stmt = $this->dbh->prepare($query);
        }
        //het koppelen van variablen aan een statement 
        public function bind($param, $value, $type = null){
            if (is_null($type)) {
                switch (true) {
                    //waarneer $value een int is geef integer aan als sql typen
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    //waarneer $value een boolean is geef boolean aan als sql typen
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    //waarneer $value NUll is geef NULL aan als sql typen
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    //normaal geeft het een string terug als sql typen
                    default:
                        $type = PDO::PARAM_STR;
                }
            }
            $this->stmt->bindValue($param, $value, $type);
        }
        //het uitvoeren van het statement
        public function execute(){
            return $this->stmt->execute();
        }
        //het fetchen van alleen resultaten
        public function resultset(){
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        //het fetchen van een enkel resultaat
        public function single(){
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_ASSOC);
        }
        //het tellen van het aantal gegeven resultaten
        public function rowCount(){
            return $this->stmt->rowCount();
        }
        //het ophalen van het laatst toegevoegde id
        public function lastInsertedId(){
            return $this->dbh->lastInsertId();
        }
    }
?>