<?php
require '../db/db.php';
mysqli_select_db($conn, "project");
$errors = [];
$thanhcong = "";
try {
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $phone = $_POST['phone'];
        $password = sha1($_POST['password']);
        $confirm_password = sha1($_POST["confirm_password"]);
        $email = $_POST['email'];
        $agree = isset($_POST['agree']) ?  true : false; // Set agree to true if it is checked, otherwise set it to false

        if (empty($username) || strlen($username) < 3 || strlen($username) > 20) {
            $errors['username'] = "Username must be between 3 and 20 characters.<br>";
        }
        if (empty($password) || strlen($_POST['password']) < 3 || strlen($_POST['password']) > 20) { // Check length of $_POST['password']
            $errors['password'] = "Password must be between 3 and 20 characters.<br>";
        }
        if (empty($phone) || strlen($phone) !== 10) { // Check length of $phone
            $errors['phone'] = "Phone number must have exactly 10 digits.<br>";
        }
        if ($password !== $confirm_password) { // Check password and confirm password match
            $errors['password2'] = "Password and Confirm Password must be the same.<br>";
        }
        if (!$agree) { // Check if user has agreed to terms and conditions
            $errors['agree'] = "Please agree to the terms and conditions.<br>";
        }

        $sql = "SELECT email,user_name FROM User";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($row['email'] === $email) {
                $errors['email'] = "Email already exists.<br>";
            }

            if ($row['user_name'] === $username) {
                $errors['username3'] = "username already exists.<br>";
            }
        }
        if (empty($errors)) {
            $sql = "INSERT INTO `User` (user_name, email, phone_number, password) VALUES ('$username', '$email', '$phone', '$password')";
            if (empty($errors)) {
                $sql = "INSERT INTO `User` (user_name, email, phone_number, password) VALUES ('$username', '$email', '$phone', '$password')";
                if ($conn->query($sql) === TRUE) {
                    // $thanhcong = "Successful!";
                    // Gắn đoạn code JavaScript vào đây
                    echo '<script>';
                    echo 'var result = confirm("You have successfully created an account! Do you want to log in as well?");';
                    echo 'if (result) { window.location.href = "login.php"; }';
                    echo '</script>';
                } else {
                    echo "Failed: ";
                }
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
    <link rel="stylesheet" href="./stylesheet/register2.css">
    <title>Register</title>
</head>

<body>
    <form method="POST">
        <div class="container">

            <div class=header>
                <h1>Registration Form</h1>
                <p>Please enter the form below to register.</p>
            </div>
            <table>
                <tr>
                    <th><label for="Username"><b>Username</b></label></th>
                    <th>
                        <input type="text" placeholder="input username" name="username">
                        <?php if (!empty($errors['username'])) { ?>
                            <div class="error"><?php echo $errors['username']; ?></div>
                        <?php } ?>
                        <?php if (!empty($errors['username3'])) { ?>
                            <div class="error"><?php echo $errors['username3']; ?></div>
                        <?php } ?>
                    </th>
                </tr>
                <tr>
                    <th>
                        <label for="email"><b>Email</b></label>
                    </th>
                    <th>
                        <input type="email" placeholder="Enter Email" name="email">
                        <?php if (!empty($errors['email'])) { ?>
                            <div class="error"><?php echo $errors['email']; ?></div>
                        <?php } ?>
                    </th>
                </tr>
                <tr>
                    <th>
                        <label for="phone"><b>Phone</b></label>
                    </th>
                    <th>
                        <input type="text" placeholder="phone" name="phone" required>
                        <?php if (!empty($errors['phone'])) { ?>
                            <div class="error"><?php echo $errors['phone']; ?></div>
                        <?php } ?>
                    </th>
                </tr>

                <tr>
                    <th>
                        <label for="psw"><b>Password</b></label>
                    </th>
                    <th>
                        <input type="password" placeholder="Enter password" name="password" required>
                        <?php if (!empty($errors['password'])) { ?>
                            <div class="error"><?php echo $errors['password']; ?></div>
                        <?php } ?>
                    </th>
                </tr>
                <tr>
                    <th>
                        <label for="psw-repeat"><b>Confirm password</b></label>
                    </th>
                    <th>
                        <input type="password" placeholder="Enter the password" name="confirm_password" required>
                        <?php if (!empty($errors['password2'])) { ?>
                            <div class="error"><?php echo $errors['password2']; ?></div>
                        <?php } ?>
                    </th>
                </tr>
                <tr>
                    <th>
                        <label>
                            <input class="error" type="checkbox" checked="checked" name="agree" style="margin-bottom:15px"> Age Confirmation
                        </label>
                        <?php if (!empty($errors['agree'])) { ?>
                            <div class="error"><?php echo $errors['agree']; ?></div>
                        <?php } ?>
                    </th>

                </tr>
                <tr>
                    <th>
                        <button type="submit" class="signupbtn" name="submit">Sign Up</button>
                    </th>
                    <th>
                        <a href="login.php">Account Login</a>|
                        <a href="./index.php">Home Page</a>

                    </th>
                    
                </tr>

            </table>
        </div>
    </form>

</body>

</html>