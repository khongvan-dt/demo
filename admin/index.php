<?php
session_start();
require '../db/db.php';


$errors = [];

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = sha1($_POST['password']);

    if (empty($username)) {
        $errors['username'] = 'Tên đăng nhập không được bỏ trống.';
    }

    if (empty($_POST['password'])) {
        $errors['password'] = 'Mật khẩu không được bỏ trống.';
    }
    mysqli_select_db($conn, "project");

    if (empty($errors)) {
        $sql = "SELECT * FROM users_admin WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $res = mysqli_fetch_assoc($result);

            if ($password === $res['PASSWORD_HASH']) {
                $_SESSION['loggedin'] = true;
                header('Location: products.php');
            } else {
                $errors['login'] = 'Sai tên đăng nhập hoặc mật khẩu.';
            }
        } else {
            $errors['login'] = 'Invalid username.';
        }
    }

    mysqli_close($conn);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - SB Admin</title>
    <link rel="stylesheet" href="./css/styles.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <form method="post">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light my-4">Login Admin</h3>
                                    </div>
                                    <div class="card-body">
                                        <form>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="username" id="username" />
                                                <label for="username">Username</label>
                                                <?php if (!empty($errors['username'])) {
                                                    echo $errors['username'];
                                                } ?>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="password" id="inputPassword" type="password" placeholder="Password" />
                                                <label for="inputPassword">Password</label>
                                                <?php if (!empty($errors['password'])) {
                                                    echo $errors['password'];
                                                } ?>
                                                <button type="submit" name="submit" value="login" class="btn btn-primary">login</button>
                                            </div>

                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>

        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </form>
</body>

</html>