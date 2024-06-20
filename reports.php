<?php
    include 'config.php';
    $query = "SELECT * FROM reports_table";
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
        $delete_query = "DELETE FROM reports_table WHERE id = '$delete_id'";
        mysqli_query($conn, $delete_query) or die('Delete query failed');
        
        // Redirect to the same page after deletion
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }

    if(isset($_POST['submit'])){
        $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
        $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
        $middleName = mysqli_real_escape_string($conn, $_POST['middleName']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $contact = mysqli_real_escape_string($conn, $_POST['contact']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        $select = mysqli_query($conn, "SELECT * FROM reports_table WHERE 
                lastName = '$lastName' AND
                firstName = '$firstName' AND
                middleName = '$middleName' AND
                address = '$address' AND
                contact = '$contact' AND
                email = '$email'") or die('query failed');

            if(mysqli_num_rows($select) > 0){
                $messageError[] = "User already exists";
            }else{
                mysqli_query($conn, "INSERT INTO reports_table
                    (lastName, firstName, middleName, address, contact, email) VALUES (
                        '$lastName',
                        '$firstName',
                        '$middleName',
                        '$address',
                        '$contact',
                        '$email')") or die('query failed');
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
    <title>Reports</title>
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

    <div class="reports_input">
        <div class="reports-box">
            <div class="reports_header">
                <h1>New Reports</h1>
            </div>
            <form action="" method="post">
                <div class="reports_details_box">
                    <div class="reports_loan">
                        <label for="">Last Name</label><br>
                        <input type="text" name="lastName">
                    </div>
                    <div class="reports_loan">
                        <label for="">First Name</label><br>
                        <input type="text" name="firstName">
                    </div>
                    <div class="reports_loan">
                        <label for="">Middle Name</label><br>
                        <input type="text" name="middleName">
                    </div>
                    <div class="reports_loan">
                        <label for="">Address</label><br>
                        <input type="text" name="address">
                    </div>
                    <div class="reports_loan">
                        <label for="">Contact#</label><br>
                        <input type="text" name="contact">
                    </div>
                    <div class="reports_loan">
                        <label for="">Email</label><br>
                        <input type="text" name="email">
                    </div>
                </div>
                <div class="reports_button">
                    <div class="payment_box_button">
                        <input type="submit" name="submit" value="Save" class="save-btn">
                        <button name="cancel" class="cancel-btn">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="loan-top-container">
        <h1>REPORTS</h1>
        <div class="loan-Btn">
            <button class="addreports"><i class="fa-solid fa-plus" style="color: #ffffff;"></i>  New Reports</button>
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
                    <th>LOAN APPLICATION REPORT</th>
                    <th>LOAN APPROVAL REPORT</th>
                    <th>NEXT PAYMENT SCHEDULE</th>
                    <th>ACTION</th>
                </tr>
                <tr class="borrower_table">
                <?php
                            while($row = mysqli_fetch_assoc($result))
                        {
                            ?>  
                                <td><?php echo $row['id'] ?></td>  
                                <td>
                                    <p>Name: <?php echo $row['firstName'] . ' ' . $row['lastName']; ?></p>                                
                                    <p>Address: <?php echo $row['address'];?></p>                                
                                    <p>Contact#: <?php echo $row['contact'];?></p>                                
                                    <p>Email: <?php echo $row['email'];?></p>                                                               
                                </td>
                                <td><h3>NONE</h3></td>
                                <td><h3>N/A</h3></td>
                                <td>
                                    <div class="btn_del_edit">
                                        <form action="" method="post">
                                            <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" name="delete_btn" class="delete-Btn">        
                                                <i class="fa-solid fa-trash fa-lg" style="color: #ffffff;"></i>
                                            </button>
                                        </form>
                                        <form action="" method="post">
                                            <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" name="edit_btn" class="edit-Btn" onclick="window.location.href='editReports.php?id=<?php echo $row['id']; ?>'; return false;">
                                                <i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php
                        }                     
                    ?>
                </tr>
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
        const addReports = document.querySelector('.addreports');
        const ReportsInput = document.querySelector('.reports_input');

        addReports.addEventListener('click', function() {
            ReportsInput.style.display = (ReportsInput.style.display === 'none' || ReportsInput.style.display === '') ? 'flex' : 'none';
        })
    </script>
</body>
</html>