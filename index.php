<?php
    include 'config.php';

    

    if(isset($_POST['submit'])){
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $select = mysqli_query($conn, "SELECT * FROM admin_table WHERE username = '$username' AND password = '$password' ");
    if(mysqli_num_rows($select) > 0){
        $row = mysqli_fetch_assoc($select);
        echo $_SESSION ["user-id"] = $row['id'];
        header("location:home.php");
      }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="styles/login.css">
    <title>Login Page</title>
</head>
<body>
    <div class="container">
        <div class="side-image">
            <img src="assets/approvedImage.jpg" alt="" class="bgImage">
        </div>
            <form action="" method="post">
                <div class="box-icon">
                    <img src="assets/money.png" alt="" width="80px">
                </div>
                <div class="input-btn">
                    <div class="input-button">
                        <label for="">Username</label><br>
                        <input type="text" name="username" class="box">
                    </div>
                    <div class="input-button">
                        <label for="">Password</label><br>
                        <input type="password" name="password" class="box">
                    </div>
                </div>
                <div class="loginBtn">
                    <input type="submit" name="submit" value=" Login now " class="btn">
                </div>
            </form>
    </div>
</body>
</html>