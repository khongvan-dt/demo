<?php


$loi = [];

if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    try {
        $conn = new PDO("mysql:host=localhost;dbname=project", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM User WHERE email = ?");
        $stmt->execute([$email]);

        $count = $stmt->rowCount();

        if ($count == 0) {
            $loi['loi'] = "Email của bạn chưa đăng ký";
        } else {
            $password_new = strval(rand(100000, 999999));

            $password_md5 = sha1($password_new);

            $stmt = $conn->prepare("UPDATE User SET password = ? WHERE email = ?");
            $stmt->execute([($password_md5), $email]);

            sendNewPasswordByEmail($email, $password_new);

            // header('Location: login.php');
            exit();
        }
    } catch (PDOException $e) {
        $loi['loi'] = "Lỗi kết nối database: " . $e->getMessage();
    }
}

function sendNewPasswordByEmail($email, $password_new)
{

    require_once "PHPMailer-master/src/PHPMailer.php";
    require_once "PHPMailer-master/src/SMTP.php";
    require_once 'PHPMailer-master/src/Exception.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->CharSet  = "utf-8";
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'khongvandt14082004@gmail.com'; // replace with your email address
        $mail->Password = 'vcfvvandnismcsas'; // replace with your email password
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;


        //Recipients
        $mail->setFrom('khongvandt14082004@gmail.com', 'vn.kk'); // replace with your name and email address
        $mail->addAddress($email); // Recipient


        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Thư đổi lại mật khẩu';
        $password_base64 = base64_encode($password_new);
        $noidungthu = "<p>Đây là mật khẩu mới của bạn để đăng nhập tại trang web của chúng tôi:</p>
          <p>Mật khẩu mới của bạn là: {$password_new}</p>";
        $mail->Body = $noidungthu;

        // $mail->send();
        $check = $mail->send();
        var_dump($check);
    } catch (Exception $e) {
        echo $e->getMessage();
        error_log($e->getMessage());
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./stylesheet/forget.css">
    <title>Forgot password</title>
</head>

<body>
    <div class="container">
        <form action="" method="post">
            <div class="title">
                <h2>FORGOT PASSWORD</h2>
                <div class="h22">
                    Have you forgotten your password? Don't worry, enter the email with which you registered your
                    account
                </div>
            </div>
            <?php if ($loi != "") { ?>
                <div class="alert alert-danger"><?php

                        if (isset($loi['loi'])) {
                            echo $loi['loi'];
                        }
                        ?></div>
            <?php } ?>
            <div class="gmail">
                <label for="email"><b></b></label>
                <input value="<?php if (isset($email) == true) echo $email ?>" type="email" class="form-control" id="email" name="email">
            </div>
            <div class="login">
                <p><button type="submit" name="submit">SEND</button></p>
            </div>

            <div class="container2">
                <span class="psw"><a href="./register.php">Register</a></span>
                <span class="psw">| <a href="./login.php">Login</a></span>
            </div>
        </form>
    </div>
</body>

</html>