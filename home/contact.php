<?php
session_start();
if (empty($_SESSION['login'])) {
  header('Location: login.php');
  exit();
}
require "../db/db.php";
if (isset($_POST['contact'])) {
  $name = $_POST['name'];
  $email = $_SESSION['email'];
  $message = $_POST['message'];
  $phone = $_SESSION['phone_number'];
  $product = $_POST['product'];
  $user_id = $_SESSION['User_id'];
  $sql = "INSERT INTO FeedBack (fullname, email, phone_number, subject_name, note, User_id) 
          VALUES ('$name', '$email', '$phone', '$product', '$message', '$user_id')";
  if ($conn->query($sql) === TRUE) {
    echo '<script>';
    echo 'var result = confirm("You have successfully submitted your feedback!");';
    echo 'if (result) { window.location.href = "contact.php"; }';
    echo '</script>';
  } else {
    echo "Failed: " . $conn->error;
  }
}
$s2 = "SELECT * FROM name_shop";
$r2 = $conn->query($s2);
$lt2 = $r2->fetch_assoc();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&family=Ruslan+Display&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./stylesheet/contact.css">
  <title>Feedback</title>

</head>

<body>

  <div class="ctn">
    <div class="header mt">
      <div class="b1">
        <div class="header2">
          <div class="logo">

            <h1><?php echo $lt2['title']; ?></h1>
          </div>
          <div class="me">
            <div id="font" style=" margin: 0 auto;"><a class="font2" href="./index.php">Home Page</a></div>
            <div id="font"><a class="font2" href="./introduce.php">Introduce</a></div>
            <div id="font">
              <a href="./product.php" class="font2">All Products</a>
            </div>

            <?php if (isset($_SESSION['login'])) { ?>
              <div id="font">
                <a class="font2" href="./contact.php">Contact</a>
              </div>
              <div>

                <a class="font2" href="./oder_user.php">Order</a>

              </div>
              <div class=" aspect-ratio-169 font ">
                <a href="./account_information.php"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-check-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                    <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                  </svg></a>
                <a href="./login_out.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
                    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                  </svg></a>
              </div>

            <?php } else { ?>
              <div class=" aspect-ratio-169 font">
                <a class="font2 f" href="./register.php">Register an account</a>
              </div>
              <div class="font">
                <a class="font2 f" href="./login.php">Login</a>
              </div>
            <?php } ?>

          </div>


        </div>
        <div class="b22">
          <div class="b44"><input class="input" type="text"></div>
          <div class="b33">
            <div><i class="fa-solid fa-magnifying-glass id "></i></div>
            <div id="fa-cart-shopping"><a href="./oder.php"><i class="fa-solid fa-cart-shopping id"></a></i></div>
          </div>

        </div>
      </div>
    </div>
    <div class="header dt">
      <div class="b1">
        <div class="header2">
          <div class="logo">

            <h1><?php echo $lt2['title']; ?></h1>
          </div>
          <div class="menu">
            <div id="font" style=" margin: 0 auto;"><a class="font2" href="./index.php">Home Page</a></div>
            <div id="font"><a class="font2" href="./introduce.php">Introduce</a></div>
            <div id="font">
              <a href="./products.php" class="font2">All Products</a>
            </div>

            <?php if (isset($_SESSION['login'])) { ?>
              <div id="font">
                <a class="font2" href="./contact.php">Contact</a>
              </div>
              <div class=" aspect-ratio-169 font ">
                <a href="./account_information.php"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-check-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                    <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                  </svg></a>
                <a href="./login_out.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
                    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                  </svg></a>
              </div>
            <?php } else { ?>
              <div class=" aspect-ratio-169 font">
                <a class="font2 f" href="./register.php">Register an account</a>
              </div>
              <div class="font">
                <a class="font2 f" href="./login.php">Login</a>
              </div>
            <?php } ?>
          </div>
        </div>

      </div>
    </div>

  </div>

  <header>
    <h2>Contact us</h2>
  </header>
  <div class="t1 mt">
    <div id="form">
      <div class="t3">
        <div id="end22">
          <div id="end1">
            <div id="end3">
              <div class="icon2">
                <div class="icon">
                  <i class="fa-sharp fa-solid fa-location-dot"></i>
                </div>
                <h3>Our address</h3>
              </div>
              <div class="f1">
                <p> 285 Doi Can Ba ​​Dinh Hanoi
                </p>

              </div>
            </div>
          </div>
          <div id="end1">
            <div id="end3">
              <div class="icon2">
                <div class="icon">
                  <i class="fa-solid fa-phone-volume"></i>
                </div>
                <h3>Phone number</h3>
              </div>
              <div class="f1">19004477</div>
            </div>
          </div>
          <div id="end1">
            <div id="end3">
              <div class="icon2">
                <div class="icon">
                  <i class="fa-solid fa-envelope"></i>
                </div>
                <h3>Email Address</h3>
              </div>
              <div class="f1">
                Email:admin@demo037146.web30s.vn
              </div>
            </div>
          </div>

        </div>
        <div class="bando">
          <a href="https://www.google.com/maps/place/P.+%C4%90%E1%BB%99i+C%E1%BA%A5n,+V%C4%A9nh+Ph%C3%BAc,+Ba+%C4%90%C3%ACnh,+H%C3%A0+N%E1%BB%99i,+Vi%E1%BB%87t+Nam/@21.0378544,105.8084246,17z/data=!3m1!4b1!4m6!3m5!1s0x3135ab0cfe2b9b53:0x944735747d98fa87!8m2!3d21.0378494!4d105.8109995!16s%2Fg%2F11h1t1qx1?hl=vi"><img class="map" src="./file ảnh/map.jpg"></a>
        </div>
      </div>
      <form id="waterform" method="post">

        <div class="formgroup" id="name-form">
          <label for="name">Your name*</label>
          <input type="text" id="name" name="name" />
        </div>

        <div class="formgroup" id="product">
          <label for="product">Product</label>
          <input type="text" id="product" name="product" />
        </div>

        <div class="formgroup" id="message-form">
          <label for="message">Your message</label>
          <textarea id="message" name="message"></textarea>
        </div>

        <input type="submit" name="contact" value="Send your message!" />
      </form>

    </div>
  </div>


  <div class="t1 dt">
    <div id="form">
      <form id="waterform" method="post">

        <div class="formgroup" id="name-form">
          <label for="name">Your name*</label>
          <input type="text" id="name" name="name" />
        </div>

        <div class="formgroup" id="product">
          <label for="product">Product</label>
          <input type="text" id="product" name="product" />
        </div>

        <div class="formgroup" id="message-form">
          <label for="message">Your message</label>
          <textarea id="message" name="message"></textarea>
        </div>

        <input type="submit" name="contact" value="Send your message!" />
      </form>

    </div>
  </div>
  <div id="end">
    <div id="end1">
      <div id="end3">
        <div class="f1"><i class="fa-solid fa-truck-fast"></i> Free shipping</div>
        <div class="wght">Customers can conveniently shop and order with many other forms
          together</div>
      </div>
    </div>
    <div id="end1">
      <div id="end3">
        <div class="f1"><i class="fa-solid fa-print"></i>Secure payment</div>
        <div class="wght">To bring convenience and cost savings to customers when shopping</div>
      </div>
    </div>
    <div id="end1">
      <div id="end3">
        <div class="f1"><i class="fa-solid fa-phone-volume"></i></i>24/7 Support</div>
        <div class="wght">Quick arrival time is always ready to serve you 24/7</div>
      </div>
    </div>
    <div id="end1">
      <div id="end3">
        <div class="f1"><i class="fa-sharp fa-solid fa-location-arrow"></i>Communications</div>
        <div class="wght">Address:
          285 Doi Can Ba ​​Dinh Hanoi
          Phone:
          19009477
          Email:
          admin@demo037146.web30s.vn</div>
      </div>
    </div>

  </div>
</body>

</html>