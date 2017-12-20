<?php
    session_start();
    include_once('inc/head.php');
    include_once('../classes/database.class.php');
    include_once('../classes/user.class.php');
    include_once('../classes/product.class.php');
    include_once('../classes/cart.class.php');
    include_once('../classes/invoice.class.php');

    $userClass = new User();
    
    if(!$userClass->checkUser()){
        header("Location: ../index.php");
        exit();
    }

    $productClass = new Product();
    $products = $productClass->selectAllProducts();

    $invoiceClass = new Invoice();
    $invoice = $invoiceClass->selectSingleInvoice($_GET['id']);

    if(!($invoice[0]['customer'] == $_SESSION['user_id'])){
        header("Location: ../index.php");
        exit();     
    }

    $userClass = new User();
    $userInfo = $userClass->getUserData($_SESSION['user_id']);

    include_once('inc/header.php');
?>
<body>
    <br><br><br><br>
    <div class="content-body">
        <div class="vertical-center">           
            <div class="container">  
                <div class="col-md-12">
                    <header class="clearfix">
                        <div class="col-md-6">
                            <a onclick="window.print()" class="btn btn1 control-group">Print this page</a><br>
                            <h1>Factuur</h1>
                            <div id="company" class="clearfix">
                                <div></div>
                                <div>visagiebycem@gmail.com</div>
                            </div><br>
                            <div id="project">
                                <div><span>FACTUURNUMMER </span><?php echo $invoice[0]['id'];?></div>
                                <div><span>CLIENT </span><?php echo $userInfo['firstname'].' '.$userInfo['insertion'].' '.$userInfo['lastname']; ?></div>
                                <div><span>ADRES </span><?php echo $userInfo['street'].' '.$userInfo['housenumber'].$userInfo['extension']; ?></div>
                                <div><span>POSTCODE </span><?php echo $userInfo['zip']; ?></div>
                                <div><span>DATUM </span> <?php echo $invoice[0]['date']; ?></div>
                                <div><span>TERMS </span> Het bedrag moet binnen 5 dagen overmaakt zijn naar IBAN: IBAN13151315</div>
                            </div>
                        </div>
                        <div class="col-md-4" id="logo">
                            <br><br><br><br><br>
                            <img class="invoice-logo" src="../assets/images/logo_roze.png">
                        </div>
                    </header><br>
                    <main>
                        <table>
                            <thead>
                                <tr>
                                    <th class="service">PRODUCT</th>
                                    <th class="desc">PER STUK</th>
                                    <th class="desc">AANTAL</th>
                                    <th class="desc">TOTAAL PLANT</th>
                                    <th class="total">TOTAAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    
                                    $totaal = 0;

                                    foreach($invoice as $invoiceInfo){  
                                         $product = $productClass->selectSingleProduct($invoiceInfo['product']);
                                         echo '<tr>';
                                            echo '<td class="service">'.$product['name'].'</td>';
                                            echo '<td class="desc">&euro; '.($invoiceInfo['price_unit'] / 100).'</td>';
                                            echo '<td class="desc">'.$invoiceInfo['quantity'].'</td>';
                                            echo '<td class="desc">&euro; '.(($invoiceInfo['price_unit'] * $invoiceInfo['quantity']) / 100).'</td>';
                                            echo '<td class="desc"></td>';
                                        echo '</tr>';
                                        
                                        $totaal = $totaal + (($invoiceInfo["price_unit"] * $invoiceInfo['quantity']) / 100);
                                    }
                                ?>
                                <tr>
                                    <td colspan="4">Shipping fee</td>
                                    <td class="total">&euro;<?php echo $invoice[0]['fee'];?></td>
                                </tr>
                                <tr>
                                    <td colspan="4">TAX <?php echo $invoice[0]['btw']; ?>%</td>
                                    <td class="total">&euro;<?php $btw = number_format(($totaal / 100) * $invoice[0]['btw'], 2, '.', ''); echo $btw;?></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="grand total">TOTAAL</td>
                                    <td class="grand total">&euro;<?php echo $totaal + $btw + $invoice[0]['fee'];?></td>
                                </tr>
                            </tbody>
                        </table>
                    </main>
                </div>
            </div>
        </div>
    </div>
    <div class="control-group">
        <?php
            include_once('inc/footer.php');
        ?>
    </div>
</body>
