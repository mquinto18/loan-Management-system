<?php 
    include 'config.php';
    $id = $_GET["id"];

    if (isset($_POST["updateBtn"])) {
        $loan = $_POST['loanNumber'];
        $payee = $_POST['payee'];
        $amount = $_POST['amount'];
        $penalty = $_POST['penalty'];
      
        $sql = "UPDATE `payment_table` SET `loanNumber`='$loan',`payee`='$payee',`amount`='$amount',`penalty`='$penalty' WHERE id= $id";
      
        $result = mysqli_query($conn, $sql);
      
        if ($result) {
          header("Location: payment.php?msg=Data updated successfully");
        } else {
          echo "Failed: " . mysqli_error($conn);
        }
      }

    if(isset($_POST['cancel'])){
        header("Location: payment.php?msg=Data cancelled");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Payment Edit</title>
</head>
<body>
    <?php
        $sql = "SELECT * FROM `payment_table` WHERE id= $id LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
    ?>
    <div class="editpayment_input">
        <div class="editpayment-box">
            <div class="editpayment_header">
                <h1>New Payment</h1>
            </div>
            <form action="" method="post">
                <div class="editpayment_details_box">
                    <div class="editpayment_loan">
                        <label for="">Loan Reference No.</label><br>
                        <input type="text" name="loanNumber" value="<?php echo $row['loanNumber'] ?>">
                    </div>
                    <div class="editpayment_loan">
                        <label for="">Payee</label><br>
                        <input type="text" name="payee" value="<?php echo $row['payee'] ?>">
                    </div>
                    <div class="editpayment_loan">
                        <label for="">Amount</label><br>
                        <input type="text" name="amount" value="<?php echo $row['amount'] ?>">
                    </div>
                    <div class="editpayment_loan">
                        <label for="">Penalty</label><br>
                        <input type="text" name="penalty" value="<?php echo $row['penalty'] ?>">
                    </div>
                    <div class="editpayment_loan">
                        <label for="">Payment Method</label><br>
                        <select name="" id="">
                            <option value="Gcash">Gcash</option>
                            <option value="Paypal">PayPal</option>
                            <option value="paymaya">PayMaya</option>
                        </select>
                    </div>
                </div>
                <div class="payment_button">
                    <div class="payment_box_button">
                        <input type="submit" name="updateBtn" value="Save" class="save-btn">
                        <button name="cancel" class="cancel-btn">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>