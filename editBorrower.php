<?php 
    include 'config.php';
    $id = $_GET["id"];

    if (isset($_POST["updateBtn"])) {
        $lastName = $_POST['lastName'];
        $firstName = $_POST['firstName'];
        $middleName= $_POST['middleName'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];
        $email = $_POST['email'];
        $coMaker = $_POST['coMaker'];
      
        $sql = "UPDATE `borrower_table` SET `lastName`='$lastName',`firstName`='$firstName',
        `middleName`='$middleName',`address`='$address',`contact`='$contact',`email`='$email',`coMaker`='$coMaker' WHERE id= $id";
      
        $result = mysqli_query($conn, $sql);
      
        if ($result) {
          header("Location: borrower.php?msg=Data updated successfully");
        } else {
          echo "Failed: " . mysqli_error($conn);
        }
      }

    if(isset($_POST['cancel'])){
        header("Location: borrower.php?msg=Data cancelled");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Borrower Edit</title>
</head>
<body>
    <?php
        $sql = "SELECT * FROM `borrower_table` WHERE id= $id LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
    ?>
    <div class="editborrower_input">
        <div class="editborrower-box">
            <div class="editborrower_header">
                <h1>New Borrower</h1>
            </div>
            <form action="" method="post">
                <div class="editborrower_details_box">
                    <div class="editborrower_loan">
                        <label for="">Last Name</label><br>
                        <input type="text" name="lastName" value="<?php echo $row['lastName'] ?>">
                    </div>
                    <div class="editborrower_loan">
                        <label for="">First Name</label><br>
                        <input type="text" name="firstName" value="<?php echo $row['firstName'] ?>">
                    </div>
                    <div class="editborrower_loan">
                        <label for="">Middle Name</label><br>
                        <input type="text" name="middleName" value="<?php echo $row['middleName'] ?>">
                    </div>
                    <div class="editborrower_loan">
                        <label for="">Address</label><br>
                        <input type="text" name="address" value="<?php echo $row['address'] ?>">
                    </div>
                    <div class="editborrower_loan">
                        <label for="">Contact#</label><br>
                        <input type="text" name="contact" value="<?php echo $row['contact'] ?>">
                    </div>
                    <div class="editborrower_loan">
                        <label for="">Email</label><br>
                        <input type="text" name="email" value="<?php echo $row['email'] ?>">
                    </div>
                    <div class="editborrower_loan">
                        <label for="">Co Maker</label><br>
                        <input type="text" name="coMaker" value="<?php echo $row['coMaker'] ?>">
                    </div>
                </div>
                <div class="borrower_button">
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