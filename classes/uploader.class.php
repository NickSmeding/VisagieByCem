<?php
    class Uploader
    {
        //Standaard gegevens voor variabelen
        private $destination; //de locatie waar het bestand moet worden opgeslagen
        private $fileName; //de naam van de file die upgeload moet worden
        private $allowedExtensions; // toegestaande bestand types
        private $maxSize = '1048576'; // maximalen bytes (1048576 bytes = 1 MB)
        private $printError = TRUE; // of error moet uitgeprint worden
        private $error = ''; //string voor error

        //START - Setters
        public function setDestination($newDestination) {
            $this->destination = $newDestination;
        }
        public function setFileName($newFileName) {
            $this->fileName = $newFileName;
        }
        
        public function setPrintError($newValue) {
            $this->printError = $newValue;
        }
        
        public function setMaxSize($newSize) {
            $this->maxSize = $newSize;
        }
        
        public function setError($newError){
            $this->error = $newError;
        }
        
        public function setAllowedExtensions($newExtensions) {
            if (is_array($newExtensions)) {
              $this->allowedExtensions = $newExtensions;
            }
            else {
              $this->allowedExtensions = array($newExtensions);
            }
        }
        //END - Setters

        //START - Getters 
        public function getDestination() 
        { 
            return $this->destination; 
        }   
        
        public function getFileName() 
        { 
            return $this->fileName; 
        } 
        
        public function getAllowedExtensions() 
        { 
            return $this->allowedExtensions; 
        } 
        
        public function getMaxSize() 
        { 
            return $this->maxSize; 
        }
        
        public function getPrintError() 
        { 
            return $this->printError; 
        } 
        
        public function getError() 
        { 
            return $this->error; 
        } 
        //END - Getters

        //start upload
        public function upload($file) {

            //validatie voor het bestand
            $this->validate($file);

            //als er een error is en printerror true is teturn dan de error
            if ($this->error) {
                if ($this->getPrintError()){
                    return $this->getError();
                }
            }
            else {
                //upload het bestand naar opgegeven gegevens als dit niet lukt geef dan een error terug
                move_uploaded_file($file['tmp_name'], $this->getDestination().$this->getFileName()) 
                or $this->setError('Er is een fout opgetreden!<br />');
                
                //als er een error is en printerror true is teturn dan de error
                if ($this->getError() && $this->getPrintError()){
                    return $this->getError();
                }
            }
        }
        
        //verwijder het bestand
        public function delete($file) {
            //check of het bestand bestaat
            if (file_exists($file)) {
                //verwijder het bestand als dit niet lukt geef error
                unlink($file) or $this->setError('Er is een fout opgetreden!<br />');
            }
        }

        
        //bestand validatie
        public function validate($file) {

            $error = '';
            
            //check of het bestand al bestaat op de opgegeven locatie
            if (file_exists($this->getDestination().$this->getFileName())) {
                $error .= 'Dit bestand bestaat al!<br />';
            }
            //check of het opgegeven bestand wel bestaat
            if (empty($file['name'][0])){
                $error .= 'Geen bestand gevonden!<br />';
            }
            //check of het bestand wel het goeie bestand typen is
            if (!in_array($this->getExtension($file),$this->getAllowedExtensions())){
                $error .= 'Dit typen bestand is niet toegestaan!<br />';
            }
            //check of het bestand niet groter is dan toegestaan
            if ($file['size'][0] > $this->getMaxSize()){
                $error .= 'Het bestand mag niet groter zijn dan '.$this->getMaxSize().' bytes!<br />';
            }

            $this->setError($error);
        }
        
        //krijg het bestands typen
        public function getExtension($file) {

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $ext = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);

            return $ext;
            
        }
        //END - Validatie
    }
?>