<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Contactformulier</title>
    </head>
    <body>

    <div>
        <div class="container">
        
            <h3 class="well">Contactformulier</h3>
        
              
            <form role="form" method="post" accept-charset="UTF-8"> <!-- From, alle gegevens die worden ingevoerd in form. worden verstuurd in de POST (geïncrypt in UTF-8) (stap 1) -->

                        <div class="col-sm-12"> <!-- Breedte van form -->

                                                        <!--Radiobuttons, Aanhef Mevrouw, De heer

                                                        <div class="form-check">
                                                            <label for="gender">Aanhef*</label>
                                                            <div>
                                                                <input class="form-check-input" type="radio" name="gender" id="gender" value="mevrouw">
                                                                Mevrouw

                                                                <input class="form-check-input" type="radio" name="gender" id="gender" value="heer">
                                                                De heer
                                                            </div>

                                                        </div>-->

                            <!--                            Voornaam, tussenvoegsel en achternaam-->                 
                            
                            <div class="row">
                                <div class="col-sm-4 form-group">
                                    <label for="firstName">Voornaam</label>
                                    <input type="text" placeholder="Typ hier uw voornaam in.." id="firstName" name="firstName" class="form-control" required>
                                </div>
                                <div class="col-sm-4 form-group">
                                    <label for="insertion">Tussenvoegsel</label>
                                    <input type="text" placeholder="Typ hier uw tussenvoegsel in.." id="insertion" name="insertion" class="form-control">
                                </div>
                                <div class="col-sm-4 form-group">
                                    <label for="lastName">Achternaam</label>
                                    <input type="text" placeholder="Typ hier uw achternaam in.." id="lastName" name="lastName" class="form-control" required>
                                </div>
                            </div>
                             <!--                            E-mailadres-->
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <label for="email">E-mailadres</label>
                                    <input type="email" placeholder="Typ hier uw e-mailadres in.." id="email" name="email" class="form-control" required>
                                </div>
                            </div>
                        

                            <!--                            Telefoonnummer-->
                            <div class="row">
                                <div class="col-sm-4 form-group">
                                    <div class="form-group">
                                        <label for="phoneNumber">Telefoonnummer</label>
                                        <input type="tel" placeholder="Typ hier uw telefoonnummer in.." id="phoneNumber" name="phoneNumber" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
        
            <div class="well">       
                <div class="form-group">
                    <label for="comment">Bericht:</label>
                    <textarea class="form-control" rows="10" id="comment" placeholder="Typ hier uw bericht.."></textarea>
                </div>
                <input type="submit" name="submitContact" id="submitContact" class="btn btn-lg btn-info" value="Verstuur">    
            </div>
            
            
                                   
                    
            
        </div>
    </div>
           
        
                               
        <?php
        
        ?>
    </body>
</html>
