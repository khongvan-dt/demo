<?php
session_start();
// session_destroy();

if (empty($_SESSION['login'])) {
    header('Location:login.php');
    exit();
}
require '../db/db.php';

mysqli_select_db($conn, "project");

$total = 0;
$user_id = $_SESSION['User_id'];
if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $note = $_POST["note"];

    $user_id = $_SESSION['User_id'];

    $sql = "INSERT INTO Orders (user_id, fullname, phone_number, address, note) VALUES ('$user_id', '$name', '$phone', '$address', '$note')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $order_id = mysqli_insert_id($conn);

        foreach ($_SESSION["cart"] as $product_id => $product) {

            foreach ($product as $prod) {
                $discount = $prod['discount'];
                $num = $prod["quantity"];
                $product_id = $prod["product_id"];
                $total_money = $discount * $num;
                $sql = "INSERT INTO Order_Details (order_id, product_id, num, total_money) VALUES ('$order_id', '$product_id', '$num', '$total_money')";
                mysqli_query($conn, $sql);
            }
        }

        unset($_SESSION["cart"]);

        $_SESSION["thanhcong"] = 2;
        echo '<script>';
        echo 'var result = confirm("You have successfully booked! Click ok to continue ordering!");';
        echo 'if (result) { window.location.href = "oder_user.php"; }';
        echo '</script>';
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
if (isset($_GET["product_id"])) {
    $product_id = $_GET["product_id"]; // lấy id trên url
    //$_SESSION["cart"] để  lưu thông tin sp đã đặt
    $sql = "SELECT DISTINCT Categories.category_id, Categories.category_name,
          Products.product_id, Products.name_sp, Products.discount, Products.img, Products.price, Products.description
          FROM Categories
          INNER JOIN Products ON Categories.category_id = Products.category_id
          WHERE Products.product_id = '$product_id' LIMIT 1";

    $result = $conn->query($sql);
    $list = mysqli_fetch_assoc($result);

    if (!isset($_SESSION["cart"][$user_id]) || empty($_SESSION["cart"][$user_id])) { //Kiểm tra xem giỏ hàng của người dùng có tồn tại
        // không Dòng này kiểm tra xem người dùng có giỏ hàng hay không. Nếu giỏ hàng không tồn tại, điều kiện này là đúng.

        $list['quantity'] = 1; //Đối với một sản phẩm mới được thêm vào giỏ hàng, số lượng được đặt thành 1 .
        $_SESSION["cart"][$user_id] = array($product_id => $list);
        //Một phần tử mảng mới được thêm vào mảng giỏ hàng của người dùng với `$product_id`khóa cụ thể và `$list`mảng chứa thông tin sản phẩm cho mục đầu tiên được thêm vào.
    } else {
        //Nếu sản phẩm đã tồn tại trong giỏ hàng (sử dụng hàm `array_key_exists()` để kiểm tra), thì số lượng sản phẩm được tăng lên một đơn vị

        if (array_key_exists($product_id, $_SESSION["cart"][$user_id])) { //Dòng này kiểm tra xem `$product_id`đã tồn tại trong giỏ hàng của người dùng cho sản phẩm đã cho chưa `$user_id`.
            // Nếu sản phẩm đã tồn tại, điều kiện này là đúng.
            $_SESSION["cart"][$user_id][$product_id]["quantity"] += 1; //Nếu sản phẩm đã tồn tại, số lượng sẽ tăng lên.
            $_SESSION["cart"][$user_id][$product_id]["quantity"] = intval($_SESSION["cart"][$user_id][$product_id]["quantity"]);
        } else { //Nếu mặt hàng `$product_id`chưa tồn tại, một phần tử mới sẽ được thêm vào mảng giỏ hàng của người dùng với 
            //`$product_id`khóa cụ thể và `$list`mảng chứa thông tin sản phẩm cho mặt hàng mới được thêm vào.
            $list['quantity'] = 1;
            $_SESSION["cart"][$user_id][$product_id] = $list;
        }
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&family=Ruslan+Display&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="./stylesheet/oder.css">
    <title>Cart</title>

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
    <div class="body2">
        <div>
            <h2 style="text-align: center;">
                Cart
            </h2>

        </div>
        <?php
        $total = 0;
        // Giỏ hàng trống, hiển thị thông báo
        if (!isset($_SESSION["cart"][$user_id]) || empty($_SESSION["cart"][$user_id])) {
            echo '<p style="text-align:center; font-weight:bold;">Your shopping cart is empty</p>';
        } else {
        ?>


            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>Product</th>
                        <th>Image</th>
                        <th> Price</th>
                        <th>Quantity</th>
                        <th>Into Money</th>
                        <th>Delete</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($_SESSION["cart"][$user_id] as $product_id => $product) :
                        $subtotal = $product["discount"] * $product["quantity"];
                        $total += $subtotal;
                    ?>

                        <tr>

                            <td>
                                <?php echo $product["name_sp"]; ?>
                            </td>
                            <td>
                                <img src="../admin/upload_mau/<?php echo $product["img"]; ?>" alt="<?php echo $product["name_sp"]; ?>" width="150px" height="100px">
                            </td>
                            <td>
                                <?php echo $product["discount"]; ?>$
                            </td>
                            <td>
                                <?php echo $product["quantity"]; ?>
                            </td>
                            <td>
                                <?php echo number_format($subtotal); ?> $
                            </td>
                            <td>
                                <form method="post" action="remove.php">
                                    <input type="hidden" name="product_id" value="<?= $product_id ?>">
                                    <button type="submit" onclick="return confirm('Are you sure you want to remove this product from the cart?')">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4" style="text-align: right; font-weight: bold;">Total:</td>
                        <td style="font-weight: bold;"><?php echo number_format($total); ?> $</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <div class="container" style="margin-top: 50px;">
                <h2>Customer information</h2>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="name">Full Name:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <textarea class="form-control" id="address" name="address" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="text">Note:</label>
                        <input type="text" class="form-control" id="Note" name="note" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Order</button>
                </form>
            </div>
        <?php } ?>
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