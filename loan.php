<?php
    include 'config.php';

    // Fetch data from borrower_table
    $queryBorrower = "SELECT * FROM borrower_table";
    $resultBorrower = mysqli_query($conn, $queryBorrower);

    // Fetch data from loanPlans_table
    $queryLoanPlans = "SELECT * FROM loanPlans_table";
    $resultLoanPlans = mysqli_query($conn, $queryLoanPlans);

    // Fetch data from payment_table
    $queryPayment = "SELECT * FROM payment_table";
    $resultPayment = mysqli_query($conn, $queryPayment);

    $queryLoan = "SELECT * FROM loan_table";
    $resultLoan = mysqli_query($conn, $queryLoan);

    if(isset($_GET['logout'])){
        // Destroy the session and redirect to index.php
        session_start();
        session_destroy();
        header("Location: index.php");
        exit();
    }



    if(isset($_POST['submit'])){
        $loanType = mysqli_real_escape_string($conn, $_POST['loanTypes']);
        $month = mysqli_real_escape_string($conn, $_POST['month']);
        $interest = mysqli_real_escape_string($conn, $_POST['interest']);
        $penalty = mysqli_real_escape_string($conn, $_POST['penalty']);
        $amount = mysqli_real_escape_string($conn, $_POST['loanAmount']);

        $select = mysqli_query($conn, "SELECT * FROM loan_table WHERE 
                loanType = '$loanType' AND
                month = '$month' AND
                interest = '$interest' AND
                penalty = '$penalty' AND
                amount = '$amount'") or die('query failed');

            if(mysqli_num_rows($select) > 0){
                $messageError[] = "User already exists";
            }else{
                mysqli_query($conn, "INSERT INTO loan_table
                    (loanType, month, interest, penalty, amount) VALUES (
                        '$loanType',
                        '$month',
                        '$interest',
                        '$penalty',
                        '$amount')") or die('query failed');
                $message[] = 'Thank you for filling up';

                // Redirect to the same page after form submission
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
    <title>Loan</title>
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
    <div class="loan_input">
        <div class="loan-box">
            <div class="loan_header">
                <h1>New Payment</h1>
            </div>
            <form action="" method="post">
                <div class="loan_details_box">
                    <div class="loan_loan">
                        <label for="">Loan Types</label><br>
                        <input type="text" name="loanTypes">
                    </div>
                    <div class="loan_loan">
                        <label for="">Loan Plan</label><br>
                        <div class="loanPlan_grid">
                            <div class="loan_plan">
                                <label for="">Month</label><br>
                                <input type="text" name="month">
                            </div>
                            <div class="loan_plan">
                                <label for="">Interest</label><br>
                                <input type="text" name="interest">
                            </div>
                            <div class="loan_plan">
                                <label for="">Penalty</label><br>
                                <input type="text" name="penalty">
                            </div>
                        </div>
                    </div>
                    <div class="loan_loan">
                        <label for="">Loan Amount</label><br>
                        <input type="text" name="loanAmount">
                    </div>
                    <div class="loan_loan">
                        <label for="">Purpose</label><br>
                        <input type="text" name="purpose">
                    </div>
                </div>
                <div class="borrower_button">
                    <div class="payment_box_button">
                        <input type="submit" name="submit" value="Save" class="save-btn">
                        <button name="cancel" class="cancel-btn">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="loan-top-container">
        <h1>LOAN LIST</h1>
        <div class="loan-Btn">
            <button class="addLoan"><i class="fa-solid fa-plus" style="color: #ffffff;"></i>  Create New Application</button>
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
                    <th>BORROWERS</th>
                    <th>LOAN DETAILS</th>
                    <th>NEXT PAYMENT DETAILS</th>
                    <th>STATUS</th>
                </tr>
                <tr>
                            <?php
                                while($row = mysqli_fetch_assoc($resultBorrower))
                            {
                                $rowLoanPlans = mysqli_fetch_assoc($resultLoanPlans);

                                $rowPayments = mysqli_fetch_assoc($resultPayment);

                                $rowLoan = mysqli_fetch_assoc($resultLoan);
                                ?>  
                                    <td><?php echo $row['id'] ?></td>  
                                    <td>
                                        <p>Name: <?php echo $row['firstName'] . ' ' . $row['lastName']; ?></p>                                
                                        <p>Address: <?php echo $row['address'];?></p>                                
                                        <p>Contact#: <?php echo $row['contact'];?></p>                                
                                        <p>Email: <?php echo $row['email'];?></p>                                
                                        <p>Co Maker: <?php echo $row['coMaker'];?></p>                                   
                                    </td>
                                    <td>
                                        <p>Loan Type: <?php echo $rowLoan['loanType'];?></p>
                                        <p>Plan: <?php echo $rowLoan['month']. 'months[' . $rowLoan ['interest']. '%, ' . $rowLoan['penalty']; ?>]</p>
                                        <p>Amount:  <?php echo $rowLoan['amount'];?></p>
                                        <p>Overdue Payable Amount: <?php echo $rowPayments['penalty'];?></p>
                                    </td>
                                    <?php
                                        $query = "SELECT amount, FORMAT(SUM(amount + penalty),2) AS total_payment FROM payment_table";
                                        $result = mysqli_query($conn, $query);
                                        $rowTotalPayment = mysqli_fetch_assoc($result);
                                    ?>
                                   <td>
                                   <?php
                                        if ($rowPayments) {
                                        ?>
                                            <p>Reference: <?php echo $rowPayments['loanNumber'] ?></p>
                                            <p>Name: <?php echo $rowPayments['payee'] ?></p>
                                            <p>Monthly Amount: <?php echo $rowPayments['amount'] ?></p>
                                            <p>Penalty: <?php echo $rowPayments['penalty'] ?></p>
                                            <p>Payable Amount: <?php echo $rowTotalPayment['total_payment'] ?></p>
                                        <?php
                                        } else {
                                            echo '<p>NONE</p>';
                                            ?>
                                            
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    <td class="loanBtn_center">
                                    <?php
                                        if ($rowPayments) {
                                        ?>
                                            <p class="release">Release</p>
                                        <?php
                                        } else {
                                            ?>
                                            <button class="release">For Approval</button>
                                        <?php
                                        }
                                        ?>
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
        const addLoan = document.querySelector('.addLoan');
        const loanInput = document.querySelector('.loan_input');

        addLoan.addEventListener('click', function() {
            loanInput.style.display = (loanInput.style.display === 'none' || loanInput.style.display === '') ? 'flex' : 'none';
        })
    </script>
</body>
</html>