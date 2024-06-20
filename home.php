<?php
    include "config.php";

    if(isset($_GET['logout'])){
        // Destroy the session and redirect to index.php
        session_start();
        session_destroy();
        header("Location: index.php");
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
    <title>Home</title>
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
    
    <?php
        $query = "SELECT id, FORMAT(SUM(amount), 2) AS amount_range FROM payment_table";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
    ?>
    <main class="main-container">
        <div class="container-page">
            <div class="box-container1">
                <div class="container-top">
                    <div class="info-top">
                        <h4>PAYMENT TODAY</h4>
                        <p><?php echo $row['amount_range']; ?></p>
                    </div>
                    <div class="info-icon">
                        <img src="assets/credit-card (1).png" alt="" width="50px">
                    </div>
                </div>
                <div class="container-bottom">
                    <div class="info-bottom">
                        <a href="payment.php"><h4>VIEW PAYMENT</h4></a>
                        <img src="assets/next.png" alt="" width="20px">
                    </div>
                </div>
            </div>
            <?php
                 $query = "SELECT id, COUNT(*) as borrower_count
                 FROM borrower_table";
                 $result = mysqli_query($conn, $query);
                 $rowBorrower = mysqli_fetch_assoc($result);
            ?>
            <div class="box-container2">
                <div class="container-top">
                    <div class="info-top">
                        <h4>BORROWERS</h4>
                        <p><?php echo $rowBorrower['borrower_count']; ?></p>
                    </div>
                    <div class="info-icon">
                        <img src="assets/group (1).png" alt="" width="50px">
                    </div>
                </div>
                <div class="container-bottom">
                    <div class="info-bottom">
                        <a href="borrower.php"><h4>VIEW BORROWERS</h4></a>
                        <img src="assets/next.png" alt="" width="20px">
                    </div>
                </div>
            </div>
            <div class="box-container3">
                <div class="container-top">
                    <div class="info-top">
                        <h4>VIEW LOAN LIST</h4>
                        <p><?php echo $rowBorrower['borrower_count']; ?></p>
                    </div>
                    <div class="info-icon">
                        <img src="assets/group (1).png" alt="" width="50px">
                    </div>
                </div>
                <div class="container-bottom">
                    <div class="info-bottom">
                        <a href="loan.php"><h4>VIEW LOAN LIST</h4></a>
                        <img src="assets/next.png" alt="" width="20px">
                    </div>
                </div>
            </div>
            <div class="box-container4">
                <div class="container-top">
                    <div class="info-top">
                        <h4>TOTAL RECEIVABLE</h4>
                        <p><?php echo $row['amount_range']; ?></p>
                    </div>
                    <div class="info-icon">
                        <img src="assets/group (1).png" alt="" width="50px">
                    </div>
                </div>
                <div class="container-bottom">
                    <div class="info-bottom">
                        <a href="payment.php"><h4>VIEW PAYMENT</h4></a>
                        <img src="assets/next.png" alt="" width="20px">
                    </div>
                </div>
            </div>
            
        </div>
    </main>
</body>
</html>