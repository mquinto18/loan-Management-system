<?php 
    include 'config.php';
    $id = $_GET["id"];

    if (isset($_POST["updateBtn"])) {
        $yearMonth = $_POST['month_years'];
        $interest = $_POST['interest'];
        $montlyPenalty = $_POST['month_penalty'];
        $typeName = $_POST['typeName'];
        $description = $_POST['description'];
      
        $sql = "UPDATE `loanplans_table` SET `yearMonth`='$yearMonth',`interest`='$interest',`monthPenalty`='$montlyPenalty',
        `typeName`='$typeName', `description`='$description' WHERE id= $id";
      
        $result = mysqli_query($conn, $sql);
      
        if ($result) {
          header("Location: loanPlans.php?msg=Data updated successfully");
        } else {
          echo "Failed: " . mysqli_error($conn);
        }
      }

    if(isset($_POST['cancel'])){
        header("Location: loanPlans.php?msg=Data cancelled");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Edit</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <?php
        $sql = "SELECT * FROM `loanplans_table` WHERE id= $id LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
    ?>
    <div class="plan-form-center">
        <div class="plan-form-left">
                <div class="plan-title">
                    <h4>Plan's Form</h4>
                </div>
                <div class="plan-schedule">
                    <div class="plan-container">
                        <form action="" method="post">
                            <div>
                                <label for="">Plan (Months)</label>
                                <input type="text" name="month_years" class="types_description" value="<?php echo $row['yearMonth'] ?>"><br>
                            </div>
                            <div>
                                <label for="">Interest</label><br>
                                <input type="number" name="insterest" class="types_description" value="<?php echo $row['interest'] ?>"><br>
                            </div>
                            <div>
                                <label for="">Month Over due's Penalty</label>
                                <input type="number" name="month_penalty" class="types_description" value="<?php echo $row['monthPenalty'] ?>">
                            </div>
                            <div>
                                <label for="">Type</label>
                                <input type="text" name="typeName" class="type_description" value="<?php echo $row['typeName'] ?>"> 
                            </div>
                            <div>
                                <label for="">Description</label>
                                <input type="text" name="description" class="type_description" value="<?php echo $row['description'] ?>">
                            </div>
                            <div class="plan-button">
                                <button class="saveBtn" name="updateBtn">Save</button>
                                <button class="cancelBtn" name="cancel">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>
</body>
</html>