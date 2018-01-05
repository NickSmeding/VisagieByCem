<?php
    session_start();
    include_once('../classes/database.class.php');
    include_once('../classes/user.class.php');
    include_once('../classes/product.class.php');
    include_once('../classes/cart.class.php');
    include_once('../classes/invoice.class.php');
    include_once('inc/head.php');

    $userClass = new User();

    $invoiceClass = new Invoice();
    $invoice = $invoiceClass->selectAllInvoice();

    if (ISSET($_POST['bevestigen'])) {
        $invoiceClass->updateOrder($_POST["id"]);
    }


    //$invoiceClass = new Invoice();
    //$orderUpdate = $invoiceClass->updateOrder($id);

    include_once('inc/admin.header.php');
?>

<div class="container">
    <div class="col-sm-12">
        <h1 class="titel">Factuur bevestigen</h1>
        <table id="example1" class="table table-striped dt-responsive display table-condensed" cellspacing="0" width="100%">
            <thead>
                <tr>

                    <th>Id</th>
                    <th>Klant</th>
                    <th>Naam</th>
                    <th>Datum</th>
                    <th>Status</th>
                    <th>Werknemer</th>
                    <th>Verzend methode</th>
                    <th>Bevestigen</th>
                </tr>
            </thead>
            <tbody>

                <?php
                foreach ($invoice as $invoices) {

                    if(!($invoices["status"] == 2)){
                        echo '<tr>';
                        echo '<td>' . $invoices["id"] . '</td>';
                        echo '<td>' . $invoices["customer"] . '</td>';
                        echo '<td>' . $invoices["firstname"] . " " . $invoices["lastname"] . '</td>';
                        echo '<td>' . $invoices["date"] . '</td>';
                        echo '<td>' . $invoices["status"] . '</td>';
                        echo '<td>' . $invoices["employee"] . '</td>';
                        echo '<td>' . $invoices["shipping"] . '</td>';
                        echo '<td>';
                        echo '<button class="button "  data-target="#bevestigen" data-toggle="modal" data-id="' . $invoices["id"] . '" >
                                Bevestigen
                              </button></td>';
                        echo '</tr>';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="bevestigen" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Factuur bevestigen</h4>
            </div>
            <div class="modal-body">
                <h4 class="well">Weet u het zeker?</h4>
                <p class="well" id="name"></p>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-3">
                        <input type="submit" name="back" id="back" class="btn btn-lg btn-info btn-block" data-dismiss="modal" value="Terug">
                    </div>
                    <div class="col-sm-5">
                        <form role="form" method="post" accept-charset="UTF-8">
                            <input type="text" name="id" id="id" value="" style="display:none"/>
                            <input type="submit" class="btn btn-lg btn-warning btn-block" role="button" id="bevestigen" name="bevestigen" value="Bevestigen"></form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once ('inc/footer.php');
?>
