<?php
    include 'config.php';
    $query = "SELECT * FROM loanPlans_table";
    $result = mysqli_query($conn, $query);

    if(isset($_GET['logout'])){
        // Destroy the session and redirect to index.php
        session_start();
        session_destroy();
        header("Location: index.php");
        exit();
    }

    if(isset($_POST['delete_btn'])){
        $delete_id = mysqli_real_escape_string($conn, $_POST['delete_id']);
        
        // Delete the row from the database
        $delete_query = "DELETE FROM loanPlans_table WHERE id = '$delete_id'";
        mysqli_query($conn, $delete_query) or die('Delete query failed');
        
        // Redirect to the same page after deletion
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }

    if(isset($_POST['submit'])){
        $yearMonth = mysqli_real_escape_string($conn, $_POST['month_years']);
        $interest = mysqli_real_escape_string($conn, $_POST['insterest']);
        $monthPenalty = mysqli_real_escape_string($conn, $_POST['month_penalty']);
        $typeName = mysqli_real_escape_string($conn, $_POST['typeName']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);

        $select = mysqli_query($conn, "SELECT * FROM loanPlans_table WHERE 
                yearMonth = '$yearMonth' AND    
                interest = '$interest' AND    
                monthPenalty = '$monthPenalty' AND    
                typeName = '$typeName' AND    
                description = '$description'") or die('query failed');
            if(mysqli_num_rows($select) > 0){
                $messageError[] = "User already exist";
            }else{
                mysqli_query($conn, "INSERT INTO loanPlans_table
                    (yearMonth, interest, monthPenalty, typeName, description) VALUES (
                      '$yearMonth',
                      '$interest',
                      '$monthPenalty',
                      '$typeName',
                      '$description' 
                      )") or die('query failed');
                $message[] = 'Thank you for filling up';

                header("Location: ".$_SERVER['PHP_SELF']);
                exit();
            }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="styles/style.css">
    <title>Loan Plans</title>
</head>
<body>
    <header>
        <div class="container">
            <div class="nav_bar">
                <div class="title_page">
                    <div  class="logo-img">
                        <img src="assets/money.png" alt="" width="50px">
                    </div>
                    <div class="logoutBtn">
                        <h1>LOAN MANAGEMENT SYSTEM</h1>
                        <h1><a href="?logout=1" class="logout">Log out</a></h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="side_navbar">
        <div class="side_container">
            <ul class="nav-links">
                <li><a href="home.php">HOME</a></li>
                <li><a href="loan.php">LOANS</a></li>
                <li><a href="payment.php">PAYMENT</a></li>
                <li><a href="borrower.php">BORROWERS</a></li>
                <li><a href="loanPlans.php">LOAN PLANS % <br> TYPES</a></li>
                <li><a href="reports.php">REPORTS</a></li>
                <li><a href="user.php">USER</a></li>
            </ul>
        </div>
    </div>
    
    

    <main class="main-container">
        
            <div class="plan-form-left">
                <div class="plan-title">
                    <h4>Plan's Form</h4>
                </div>
                <div class="plan-schedule">
                    <div class="plan-container">
                        <form action="" method="post">
                            <div>
                                <label for="">Plan (Months)</label>
                                <input type="text" name="month_years" class="types_description"><br>
                            </div>
                            <div>
                                <label for="">Interest</label><br>
                                <input type="number" name="insterest" class="types_description"><br>
                            </div>
                            <div>
                                <label for="">Month Over due's Penalty</label>
                                <input type="number" name="month_penalty" class="types_description">
                            </div>
                            <div>
                                <label for="">Type</label>
                                <input type="text" name="typeName" class="type_description"> 
                            </div>
                            <div>
                                <label for="">Description</label>
                                <input type="text" name="description" class="type_description">
                            </div>
                            <div class="plan-button">
                                <button class="saveBtn" name="submit">Save</button>
                                <button class="cancelBtn">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="plan-form-right">
                <div class="table-container">
                    <table class="planLoan-container">
                        <tr class="borrower_center">
                            <th>#</th>
                            <th>PLAN</th>
                            <th>ACTION</th>
                        </tr>
                        <tr>
                            <?php
                                while($row = mysqli_fetch_assoc($result))
                            {
                                ?>  
                                    <td class="loan_center"><?php echo $row['id'] ?></td>  
                                    <td>
                                        <p>Years/Month: <?php echo $row['yearMonth'];?></p>                                
                                        <p>Interest: <?php echo $row['interest'];?>%</p>                                
                                        <p>Over dure Penalty: <?php echo $row['monthPenalty'];?>%</p>                                
                                        <p>Type Name: <?php echo $row['typeName'];?></p>                                
                                        <p>Description: <?php echo $row['description'];?></p>                                
                                    </td>
                                    <td>
                                        <div class="btn_del_edit">
                                            <form action="" method="post">
                                                <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" name="delete_btn" class="delete-Btn">        
                                                    <i class="fa-solid fa-trash fa-lg" style="color: #ffffff;"></i>
                                                </button>
                                            </form>
                                            <form action="editloanPlans.php" method="get">
                                                <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" name="edit_btn" class="edit-Btn" onclick="window.location.href='editloanPlans.php?id=<?php echo $row['id']; ?>'; return false;">
                                                    <i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                                                </button>
                                        </form>
                                        </div>
                                    </td>
                                </tr>
                        <?php
                        }                     
                    ?>
                    </table>
                </div>
            </div>
        
    </main>
</body>
</html>