<?php
    session_start();
    require '../db/db.php';
    mysqli_select_db($conn, "project");
    $errors = [];
    try {

        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $password = sha1($_POST['password']);

            if (empty($username)) {
                $errors['username'] = "Username cannot be left blank.<br>";
            }
            if (empty($password)) {
                $errors['password'] = "Password cannot be left blank.<br>";
            }
            if (empty($errors)) {
                $sql = "SELECT * FROM User WHERE user_name = '$username'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    $res = mysqli_fetch_assoc($result);
                    if ($password === $res['password']) {
                        $_SESSION['login'] = true;
                        $_SESSION['User_id'] = $res['User_id'];
                        $_SESSION['email'] = $res['email'];
                        $_SESSION['phone_number'] = $res['phone_number'];

                        header('Location: index.php');

                    } else {
                        $errors['password2'] = "wrong account password";
                    }
                } else {
                    $errors['username2'] = "wrong account name";
                }
            }
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        exit();
    }
    ?>  



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./stylesheet/login_css.css">
    <title>Login</title>
</head>

<body>

    <div class="container">

        <form action="" method="post">
            <div class="title">
                <h2>FORM LOGIN</h2>
            </div>
           
            <div class="use">
                <label for="username"><b></b></label>
                <input type="text" placeholder="Enter Username" name="username">
                <?php if (!empty($errors['username'])) { ?>
                    <div class="error"><?php echo $errors['username']; ?></div>
                <?php } ?>
                <?php if (!empty($errors['username2'])) { ?>
                    <div class="error"><?php echo $errors['username2']; ?></div>
                <?php } ?>
            </div>
            <div class="use">
                <label for="psw"><b></b></label>
                <input type="password" placeholder="Enter Password" name="password" required>

                <?php if (!empty($errors['password'])) { ?>
                    <div class="error"><?php echo $errors['password']; ?></div>
                <?php } ?>
                <?php if (!empty($errors['password2'])) { ?>
                    <div class="error"><?php echo $errors['password2']; ?></div>
                <?php } ?>
            </div>

            <div class="login">
                <p><button type="submit" name="submit">LOGIN</button></p>
            </div>

            <div class="container2">
                <span class="psw"> <a href="./forgot.php"> Forgot password?</a></span>
                <span class="psw">Do not have an account?<a href="register.php">Register now.</a></span>
                <span class="psw">or <a href="index.php">Home Page</a></span>

            </div>
        </form>
    </div>
</body>

</html>