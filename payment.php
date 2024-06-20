<?php
    include 'config.php';
    $query = "SELECT * FROM payment_table ";
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
        $delete_query = "DELETE FROM payment_table WHERE id = '$delete_id'";
        mysqli_query($conn, $delete_query) or die('Delete query failed');
        $message[] = "Data Deleted";
        // Redirect to the same page after deletion
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
    
    if(isset($_POST['submit'])){
        $loan = mysqli_real_escape_string($conn, $_POST['loanNumber']);
        $payee = mysqli_real_escape_string($conn, $_POST['payee']);
        $amount = mysqli_real_escape_string($conn, $_POST['amount']);
        $penalty = mysqli_real_escape_string($conn, $_POST['penalty']);

        $formattedAmount = number_format($amount);
        $formattedPenalty = number_format($penalty);

        $select = mysqli_query($conn, "SELECT * FROM payment_table WHERE 
            loanNumber = '$loan' AND 
            payee = '$payee' AND 
            amount = '$amount' AND 
            penalty = '$penalty' ") or die('query failed');

        if(mysqli_num_rows($select) > 0){
            $messageError[] = "User already exists";
        } else {
            mysqli_query($conn, "INSERT INTO 
            payment_table (loanNumber, payee, amount, penalty) 
            VALUES ('$loan', '$payee', '$amount', '$penalty')") or die('query failed'); 
            $message[] = 'Thank you for filling up';
        }

        // Redirect to the same page after form submission
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="styles/style.css">
    <title>Payment</title>
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

    
    <div class="payment_input">
        <div class="payment-box">
            <div class="payment_header">
                <h1>New Payment</h1>
            </div>
            <form action="" method="post">
                <div class="payment_details_box">
                    <div class="payment_loan">
                        <label for="">Loan Reference No.</label><br>
                        <input type="text" name="loanNumber">
                    </div>
                    <div class="payment_loan">
                        <label for="">Payee</label><br>
                        <input type="text" name="payee">
                    </div>
                    <div class="payment_loan">
                        <label for="">Amount</label><br>
                        <input type="text" name="amount">
                    </div>
                    <div class="payment_loan">
                        <label for="">Penalty</label><br>
                        <input type="text" name="penalty">
                    </div>
                    <div class="payment_loan">
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
                        <input type="submit" name="submit" value="Save" class="save-btn">
                        <button name="cancel" class="cancel-btn">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="loan-top-container">
        <h1>PAYMENT LIST</h1>
        <div class="loan-Btn">
            <button class="addpayBtn"><i class="fa-solid fa-plus" style="color: #ffffff;"></i>Create New Application</button>
        </div>
    </div>

    <main class="main-loan-container">
        <div class="entries-section">
            <div class="enter-container">
                <h3>Show</h3>
                <select id="">
                    <option value="">10</option>
                    <option value="">9</option>
                    <option value="">8</option>
                    <option value="">7</option>
                    <option value="">6</option>
                    <option value="">5</option>
                    <option value="">4</option>
                    <option value="">3</option>
                    <option value="">2</option>
                    <option value="">1</option>
                </select>
                <p>entries</p>
            </div>
            <div class="search-container">
                <div class="search">
                    <h4>Search: </h4>
                    <input type="text">
                </div>
            </div>
        </div>
        <div class="loan-table">
            <table>
                <tr class="center-text">
                    <th>#</th>
                    <th>LOAN REFERENCE NO</th>
                    <th>PAYEE</th>
                    <th>AMOUNT</th>
                    <th>PENALTY </th>
                    <th>ACTION</th>
                </tr>
                <tr class="borrower_center">
                        <?php
                            while($row = mysqli_fetch_assoc($result))
                        {
                            $formattedAmount = number_format($row['amount']);
                            $formattedPenalty = number_format($row['penalty']); 

                            ?>  
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $row['loanNumber'] ?></td>
                                <td><?php echo $row['payee'] ?></td>
                                <td><?php echo $formattedAmount; ?></td>
                                <td><?php echo $formattedPenalty; ?></td>    
                                <td>
                                    <div class="btn_del_edit">
                                        <form action="" method="post">
                                            <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" name="delete_btn" class="delete-Btn">        
                                                <i class="fa-solid fa-trash fa-lg" style="color: #ffffff;"></i>
                                            </button>
                                        </form>
                                        <form action="editPayment.php" method="get">
                                            <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" name="edit_btn" class="edit-Btn" onclick="window.location.href='editPayment.php?id=<?php echo $row['id']; ?>'; return false;">
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
        <div class="loan-bottom-container">
            <p>Showing 1 to 1 of 1 entries</p>
            <div class="enter-container">
                <h3>Previous</h3>
                <select id="">
                    <option value="">1</option>
                    <option value="">2</option>
                    <option value="">3</option>
                    <option value="">4</option>
                    <option value="">5</option>
                    <option value="">6</option>
                    <option value="">7</option>
                    <option value="">8</option>
                    <option value="">9</option>
                    <option value="">10</option>
                </select>
                <p>Next</p>
            </div>
        </div>
    </main>
    <script>
        const addPayBtn = document.querySelector('.addpayBtn');
        const paymentInput = document.querySelector('.payment_input');

        addPayBtn.addEventListener('click', function() {
            console.log("addPayBtn clicked");
            paymentInput.style.display = (paymentInput.style.display === 'none' || paymentInput.style.display === '') ? 'flex' : 'none';
        });

        const editaddPayBtns = document.querySelector('.edit-Btn');
        const editpaymentInput = document.querySelector('.editpayment_input');
       
        editaddPayBtns.addEventListener('click', function(btn){
            btn.preventDefault();
            editpaymentInput.style.display = (editpaymentInput.style.display === 'none' || editpaymentInput.style.display === '') ? 'flex' : 'none';
        })

    </script>
</body>
</html>