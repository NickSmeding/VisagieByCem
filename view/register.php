<!DOCTYPE html>
<html>
    <?php
        session_start();
        include_once('../classes/database.class.php');
        include_once('../classes/user.class.php');
        include_once('../classes/product.class.php');
        include_once('../classes/cart.class.php');
        include_once('../classes/instagram.class.php');
        include_once('inc/head.php');
        include_once('inc/header.php');

        $userClass = new User(); //Maakt verbinding met class user zodat je alle functions kan gebruiken uit user.class.php

        /* Als er op Submit wordt gedrukt -> worden de postgegevens in een variable userInfo gezet ->
         * daarna wordt de function in gebruik gesteld. De query's staan in user.class.php, die worden
         * uitgevoerd in de function register. $result is het resultaat van deze algoritme. (stap 3)  */
        if (isset($_POST['submitRegister'])) {
            $userInfo = $_POST;
            $result = $userClass->register($userInfo);
        }
    ?>
    <body>
        <div class="container">
            <h1 class="well">Account aanmaken</h1>
            <div class="col-lg-12 well"> <!-- grote van achtergrond accountgegevens -->

                <div class="row">
                    <h3 class="well-sm">Account gegevens</h3>
                    <form role="form" method="post" accept-charset="UTF-8"> <!-- From, alle gegevens die worden ingevoerd in form. worden verstuurd in de POST (geïncrypt in UTF-8) (stap 1) -->

                        <div class="col-sm-12"> <!-- Breedte van form -->

                            <!--                            Radiobuttons, Aanhef Mevrouw, De heer-->

                            <!--                            <div class="form-check">
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
                                    <input type="text" placeholder="Typ hier uw voornaam in.." id="firstName" name="firstName" class="form-control">
                                </div>
                                <div class="col-sm-4 form-group">
                                    <label for="insertion">Tussenvoegsel</label>
                                    <input type="text" placeholder="Typ hier uw tussenvoegsel in.." id="insertion" name="insertion" class="form-control">
                                </div>
                                <div class="col-sm-4 form-group">
                                    <label for="lastName">Achternaam</label>
                                    <input type="text" placeholder="Typ hier uw achternaam in.." id="lastName" name="lastName" class="form-control">
                                </div>
                            </div>

                            <!--                            E-mailadres-->

                            <div class="form-group">
                                <label for="email">E-mailadres</label>
                                <input type="email" placeholder="Typ hier uw e-mailadres in.." id="email" name="email" class="form-control">
                            </div>

                            <!--                            Telefoonnummer-->
                            <div class="row">
                                <div class="col-sm-4 form-group">
                                    <div class="form-group">
                                        <label for="phoneNumber">Telefoonnummer</label>
                                        <input type="tel" placeholder="Typ hier uw telefoonnummer in.." id="phoneNumber" name="phoneNumber" class="form-control">
                                    </div>

                                    <!--                            Geboortedatum-->

                                    <div class="form-group">
                                        <label for="dateOfBirth">Geboortedatum</label>
                                        <input type="date" value="" id="dateOfBirth" name="dateOfBirth" max="" class="form-control">
                                    </div>

                                    <!--                            Landkeuze-->

                                    <div class="form-group">
                                        <label for="country">Land</label>
                                        <select class="form-control" name="country">
                                            <option>Nederland</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--                            Plaats, Postcode-->

                            <div class="row">
                                <div class="col-sm-4 form-group">
                                    <label for="city">Plaats</label>
                                    <input type="text" placeholder="Typ hier uw plaats in.." id="city" name="city" class="form-control">
                                </div>

                                <!--                            Provincie, keuze uit meerdere provincie's, class form-group is de layout *css-->

                                <!--                                <div class="col-sm-4 form-group">
                                                                    <label>Provincie</label>
                                                                    <select class="form-control">
                                                                        <option>Groningen</option>
                                                                        <option>Friesland</option>
                                                                        <option>Drenthe</option>
                                                                        <option>Overijssel</option>
                                                                        <option>Flevoland</option>
                                                                        <option>Gelderland</option>
                                                                        <option>Utrecht</option>
                                                                        <option>Noord-Holland</option>
                                                                        <option>Zuid-Holland</option>
                                                                        <option>Zeeland</option>
                                                                        <option>Noord-Brabant</option>
                                                                        <option>Limburg</option>
                                                                    </select>
                                                                </div>-->
                                <div class="col-sm-2 form-group">
                                    <label for="postalCode">Postcode</label>
                                    <input type="text" placeholder="Typ hier uw postcode in.." pattern="[1-9][0-9]{3}\s?[a-zA-Z]{2}" id="postalCode" name="postalCode" class="form-control">
                                </div>
                            </div>

                            <!--                            Straatnaam, huisnummer, toevoeging-->

                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="streetName">Straatnaam</label>
                                    <input type="text" placeholder="Typ hier uw straatnaam in.." id="streetName" name="streetName" class="form-control">
                                </div>
                                <div class="col-sm-2 form-group">
                                    <label for="houseNumber">Huisnummer</label>
                                    <input type="number" placeholder="Huisnummer" max="" id="houseNumber" name="houseNumber" class="form-control">
                                </div>
                                <div class="col-sm-2 form-group">
                                    <label for="addition">Toevoeging</label>
                                    <input type="text" placeholder="Toevoeging" id="addition" name="addition" class="form-control">
                                </div>

                            </div>

                            <!--Wachtwoord-->
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="password">Wachtwoord</label>
                                    <input type="password" placeholder="Typ hier uw wachtwoord in.." id="password" name="password" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="confirmPassword">Bevestig uw wachtwoord</label>
                                    <input type="password" placeholder="Typ hier uw wachtwoord in.." id="confirmPassword" name="confirmPassword" class="form-control">
                                </div>
                            </div>





                            <input type="submit" name="submitRegister" id="submitRegister" class="btn btn-lg btn-info" value="Registeren"> <!-- submit alle gegevens naar de POST (stap 2) -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>

<?php


