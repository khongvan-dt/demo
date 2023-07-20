<?php
session_start();
require '../db/db.php';

mysqli_select_db($conn, "project");

$sql = "SELECT Categories.category_id, Categories.category_name, Products.product_id, Products.name_sp, Products.discount, Products.img
        FROM Categories
        INNER JOIN Products ON Categories.category_id = Products.category_id
        LIMIT 6;";
$result = $conn->query($sql);
$list = $result->fetch_all(MYSQLI_ASSOC);



$sql2 = "SELECT * FROM name_shop";
$result2 = $conn->query($sql2);
$list2 = $result2->fetch_assoc();


$l1 = "SELECT * FROM `display` WHERE id=2";
$display = $conn->query($l1);
$lan1 = $display->fetch_assoc();

$l2 = "SELECT * FROM `display` WHERE id=3";
$display = $conn->query($l2);
$lan2 = $display->fetch_assoc();

$l3 = "SELECT * FROM `display` WHERE id=4";
$display2 = $conn->query($l3);
$lan3 = $display2->fetch_assoc();

$l4 = "SELECT * FROM `display` WHERE id=5";
$display2 = $conn->query($l4);
$lan4 = $display2->fetch_assoc();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&family=Ruslan+Display&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="./stylesheet/home.css">

    <title>Smart Store </title>
</head>

<body>
    <div class="ctn">
        <div class="header mt">
            <div class="b1">
                <div class="header2">
                    <div class="logo">

                        <h1><?php echo $list2['title']; ?></h1>
                    </div>
                    <div class="menu">
                        <div id="font" style=" margin: 0 auto;"><a class="font2" href="./index.php">Home Page</a></div>
                        <div id="font"><a class="font2" href="./introduce.php">Introduce</a></div>
                        <div id="font">
                            <a href="./product.php" class="font2">All Products</a>
                        </div>

                        <?php if (isset($_SESSION['login'])) { ?>
                            <div id="font">
                                <a class="font2" href="./contact.php">Contact</a>
                            </div>
                            <div><a class="font2" href="./oder_user.php">Order</a></div>

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
                    <div class="b22">
                        <div class="b44"><input class="input" type="text"></div>
                        <div class="b33">
                            <div><i class="fa-solid fa-magnifying-glass id "></i></div>
                            <div id="fa-cart-shopping"><a href="./oder.php"><i class="fa-solid fa-cart-shopping id"></a></i></div>
                        </div>

                    </div>


                </div>

            </div>
        </div>
        <div class="header dt">

            <div class="header2">
                <div class="logo">

                    <h1><?php echo $list2['title'] ?></h1>
                </div>
                <div class="menu">
                    <div id="font"><a class="font2" href="./index.php">Home Page</a></div>
                    <div id="font"><a class="font2" href="./introduce.php">Introduce</a></div>
                    <div id="font">
                        <a href="./product.php" class="font2">All Products</a>
                    </div>

                    <?php if (isset($_SESSION['login'])) { ?>
                        <div id="font">
                            <a class="font2" href="./contact.php">Contact</a>
                        </div>
                        <div><a class="font2" href="./oder_user.php">Order</a></div>

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
                    <div class="b44"><input class="input" type="text"></div>
                    <div class="b33">
                        <div><i class="fa-solid fa-magnifying-glass id "></i></div>
                        <div id="fa-cart-shopping"><a href="./oder.php"><i class="fa-solid fa-cart-shopping id"></a></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="anh13">
        <img src="../admin/upload/<?php echo $list2['img_t']; ?> " style="width: 100%;">
    </div>

    <div class="m01 mt">
        <div>
            <img class="aspect-ratio-169 anh1" src="../admin/upload/<?php echo $lan1['img']; ?>">
        </div>

        <div>
            <div class="bewen">
                <h2><?php echo $lan1['title2']; ?></h2>
                <div>
                    <?php echo $lan1['title3']; ?>
                </div>
            </div>
            <div class="bewen2">
                <h2><?php echo $lan2['title2']; ?></h2>

                <div>
                    <?php echo $lan2['title3']; ?>
                </div>
            </div>
        </div>
        <div>
            <img class="aspect-ratio-169 anh01" src="../admin/upload/<?php echo $lan2['img']; ?>">
        </div>
    </div>
    <div class="m01 dt">
        <div class="m02">
            <div>
                <img class="aspect-ratio-169 anh1" src="../admin/upload/<?php echo $lan1['img']; ?>">
            </div>

            <div class="bewen">
                <h2><?php echo $lan1['title2']; ?></h2>
                <div class="font01">
                    <?php echo $lan1['title3']; ?>
                </div>
            </div>
        </div>
        <div class="m02">
            <div class="bewen2">
                <h2><?php echo $lan2['title2']; ?></h2>

                <div class="font01">
                    <?php echo $lan2['title3']; ?>
                </div>
            </div>
            <div>
                <img class="aspect-ratio-169 anh01" src="../admin/upload/<?php echo $lan2['img']; ?>">
            </div>
        </div>

    </div>
    </div>
    <div class="bewen6 mt">
        <div class="bewen3">
            <div>
                <img src="../admin/upload/<?php echo $lan3['img']; ?>" class="bewen4">
            </div>
            <div class="b3">
                <h2><?php echo $lan3['title2']; ?></h2>
                <div>
                    <?php echo $lan3['title3']; ?>
                </div>
            </div>
        </div>

        <div class="bewen5 ">
            <div><img src="../admin/upload/<?php echo $lan4['img']; ?>" class="img10"></div>
            <div class="b4">
                <div>
                    <h2><?php echo $lan4['title2']; ?></h2>
                </div>
                <div>
                    <?php echo $lan4['title3']; ?>
                </div>
            </div>
        </div>

    </div>
    <div class="bewen6 dt">
        <div class="bewen3">
            <div>
                <img src="../admin/upload/<?php echo $lan3['img']; ?>" class="bewen4">
            </div>
            <div class="b3">
                <h2><?php echo $lan3['title2']; ?></h2>
                <div class="font01">
                    <?php echo $lan3['title3']; ?>
                </div>
            </div>
        </div>

        <div class="bewen5 ">
            <div><img src="../admin/upload/<?php echo $lan4['img']; ?>" class="img10"></div>
            <div class="b4">
                <div>
                    <h2><?php echo $lan4['title2']; ?></h2>
                </div>
                <div class="font01">
                    <?php echo $lan4['title3']; ?>
                </div>
            </div>
        </div>

    </div>


    <div>
        <div>
            <h1 class="h">POPULAR PRODUCTS</h1>

        </div>
        <div class="pictures">
            <?php foreach ($list as $product) { ?>
                <div class="padding1">
                    <div class="product-card">
                        <div class="product-tumb">
                            <img class="img4" src="../admin/upload_mau/<?php echo $product['img']; ?>">
                        </div>
                        <div class="product-details">
                            <div class="product-bottom-details">
                                <h6><a href=""> <?php echo $product['name_sp']; ?></a></h6>
                                <div class="product-price">$<?php echo  $product['discount']; ?></div>

                            </div>
                        </div>
                        <div class="butun">
                            <form action="./detail.php" method="get">
                                <button class="btn btn-primary" name="detail" type="submit" value="<?php echo $product['product_id']; ?>">detail</button>
                            </form>
                            <form action="./oder.php" method="get">
                                <button class="btn btn-primary" name="product_id" type="submit" value="<?php echo $product['product_id']; ?>">buy now</button>
                            </form>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>
        <div id="end">
            <div id="end1">
                <div id="end3">
                    <div class="f1"><i class="fa-solid fa-truck-fast"></i> Free shipping</div>
                    <div class="wght">
                        Customers can conveniently shop and order with many other forms
                        together
                    </div>
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
    </div>
</body>

</html>