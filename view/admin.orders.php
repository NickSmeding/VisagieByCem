
<?php
    session_start();
    include_once('../classes/database.class.php');
    include_once('../classes/user.class.php');
    include_once('../classes/product.class.php');
    include_once('../classes/cart.class.php');
    include_once('../classes/invoice.class.php');
    include_once('inc/head.php');


    $invoiceClass = new Invoice();
    $invoice = $invoiceClass->selectAllInvoice();

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

                    echo '<tr>';
                    echo '<td>' . $invoices["id"] . '</td>';
                    echo '<td>' . $invoices["customer"] . '</td>';
                    echo '<td>' . $invoices["firstname"] . " " . $invoices["lastname"] . '</td>';
                    echo '<td>' . $invoices["date"] . '</td>';
                    echo '<td>' . $invoices["status"] . '</td>';
                    echo '<td>' . $invoices["employee"] . '</td>';
                    echo '<td>' . $invoices["shipping"] . '</td>';
                    echo '<td>';
                    ?>
                <form method="$_POST" action="mailto:gul-2000@live.nl&subject=Bevestiging order VisagiebyCem&message=Hierbij">
                    <input type="submit" name="bevestigen" value="Bevestigen">
                </form>
                <?php
                echo '</td>';
                echo '</tr>';
                if (isset($_POST["bevestigen"])) {
                    $updateOrder($invoices["id"]);
                }
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<?php
    include_once ('inc/footer.php');
?>
