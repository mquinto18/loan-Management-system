<?php
    include 'config.php';
    $query = "SELECT * FROM users_table";
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
        $delete_query = "DELETE FROM users_table WHERE id = '$delete_id'";
        mysqli_query($conn, $delete_query) or die('Delete query failed');
        $message[] = "Data Deleted";
        // Redirect to the same page after deletion
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }

    if(isset($_POST['submit'])){
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);


        $select = mysqli_query($conn, "SELECT * FROM users_table WHERE 
                name = '$name' AND
                username = '$username' AND
                password = '$password'") or die('query failed');

            if(mysqli_num_rows($select) > 0){
                $messageError[] = "User already exists";
            }else{
                mysqli_query($conn, "INSERT INTO users_table
                    (name, username, password) VALUES (
                        '$name',
                        '$username',
                        '$password')") or die('query failed');
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
    <title>Users</title>
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

    <div class="users_input">
        <div class="users-box">
            <div class="users_header">
                <h1>New Users</h1>
            </div>
            <form action="" method="post">
                <div class="users_details_box">
                    <div class="users_loan">
                        <label for="">Name</label><br>
                        <input type="text" name="name">
                    </div>
                    <div class="users_loan">
                        <label for="">Username</label><br>
                        <input type="text" name="username">
                    </div>
                    <div class="users_loan">
                        <label for="">Password</label><br>
                        <input type="password" name="password">
                    </div>
                    <div class="users_loan">
                        <label for="">User Type</label><br>
                        <select name="" id="">
                            <option value="Gcash">Admin</option>
                            <option value="Paypal">User</option>
                        </select>
                    </div>
                </div>
                <div class="users_button">
                    <div class="payment_box_button">
                        <input type="submit" name="submit" value="Save" class="save-btn">
                        <button name="cancel" class="cancel-btn">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="loan-top-container">
        <h1>USERS</h1>
        <div class="loan-Btn">
            <button class="addUsers"><i class="fa-solid fa-plus" style="color: #ffffff;"></i>  New User</button>
        </div>
    </div>

    <main class="main-loan-container">
    
        <div class="loan-table">
            <table >
                <tr class="center-text">
                    <th>#</th>
                    <th>NAME</th>
                    <th>USERNAME</th>
                    <th>ACTION</th>
                </tr>
                <tr class="borrower_center">
                <?php
                            while($row = mysqli_fetch_assoc($result))
                        {
                            ?>  
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['username'] ?></td>
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
                                            <button type="submit" name="edit_btn" class="edit-Btn" onclick="window.location.href='user.php?id=<?php echo $row['id']; ?>'; return false;">
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
    </main>
    <script>
        const addUsers = document.querySelector('.addUsers');
        const usersInput = document.querySelector('.users_input');

        addUsers.addEventListener('click', function() {
            usersInput.style.display = (usersInput.style.display === 'none' || usersInput.style.display === '') ? 'flex' : 'none';
        })
    </script>
</body>
</html>