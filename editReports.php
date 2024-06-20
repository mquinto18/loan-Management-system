<?php 
    include 'config.php';
    $id = $_GET["id"];

    if (isset($_POST["updateBtn"])) {
        $lastName = $_POST['lastName'];
        $firstName = $_POST['firstName'];
        $middleName = $_POST['middleName'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];
        $email = $_POST['email'];
      
        $sql = "UPDATE `reports_table` SET `lastName`='$lastName',`firstName`='$firstName',
        `middleName`='$middleName',`address`='$address',`email`='$email' WHERE id= $id";
      
        $result = mysqli_query($conn, $sql);
      
        if ($result) {
          header("Location: reports.php?msg=Data updated successfully");
        } else {
          echo "Failed: " . mysqli_error($conn);
        }
      }

    if(isset($_POST['cancel'])){
        header("Location: reports.php?msg=Data cancelled");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Document</title>
</head>
<body>
<?php
        $sql = "SELECT * FROM `reports_table` WHERE id= $id LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
    ?>
<div class="editreports_input">
        <div class="editreports-box">
            <div class="editreports_header">
                <h1>New Reports</h1>
            </div>
            <form action="" method="post">
                <div class="editreports_details_box">
                    <div class="editreports_loan">
                        <label for="">Last Name</label><br>
                        <input type="text" name="lastName" value="<?php echo $row['lastName'] ?>">
                    </div>
                    <div class="editreports_loan">
                        <label for="">First Name</label><br>
                        <input type="text" name="firstName" value="<?php echo $row['firstName'] ?>">
                    </div>
                    <div class="editreports_loan">
                        <label for="">Middle Name</label><br>
                        <input type="text" name="middleName" value="<?php echo $row['middleName'] ?>">
                    </div>
                    <div class="editreports_loan">
                        <label for="">Address</label><br>
                        <input type="text" name="address" value="<?php echo $row['address'] ?>">
                    </div>
                    <div class="editreports_loan">
                        <label for="">Contact#</label><br>
                        <input type="text" name="contact" value="<?php echo $row['contact'] ?>">
                    </div>
                    <div class="editreports_loan">
                        <label for="">Email</label><br>
                        <input type="text" name="email" value="<?php echo $row['email'] ?>">
                    </div>
                </div>
                <div class="editreports_button">
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