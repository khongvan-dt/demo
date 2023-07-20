<?php
session_start();
require '../db/db.php';

mysqli_select_db($conn, "project");

$s2 = "SELECT * FROM name_shop";
$r2 = $conn->query($s2);
$lt2 = $r2->fetch_assoc();


if (!isset($_GET['page'])) $page = 1;
else $page = $_GET['page'];

$limit = 12;
// get the total count of products
$sql_count = "SELECT COUNT(*) as count FROM Products";
$result_count = $conn->query($sql_count);
$count = $result_count->fetch_assoc()['count'];

// calculate the number of pages
$total_pages = ceil($count / $limit);

// calculate the offset
$offset = ($page - 1) * $limit;

// get the products for the current page
$sql = "SELECT DISTINCT Categories.category_id, Categories.category_name, Products.product_id, Products.name_sp, Products.discount, Products.img
        FROM Categories
        INNER JOIN Products ON Categories.category_id = Products.category_id
        LIMIT $offset, $limit;";
$result = $conn->query($sql);
$list = $result->fetch_all(MYSQLI_ASSOC);


$echo_find = $_GET['find2'] ?? '';
$echo_find2 = $_GET['category'] ?? '';

if (isset($_GET['find'])) {
    $write = $_GET['find2'] ?? '';
    $find = "SELECT DISTINCT Categories.category_id,Categories.category_name,Products.product_id, Products.name_sp, Products.discount, Products.img
     FROM Categories 
     INNER JOIN Products ON Categories.category_id = Products.category_id 
    WHERE Categories.category_name LIKE '%$write%' OR Products.name_sp LIKE '%$write%' OR Products.discount LIKE '%$write%'";
    $result2 = $conn->query($find);
    $list = $result2->fetch_all(MYSQLI_ASSOC);
}
$sql = "SELECT *  FROM Categories ";
$result3 = $conn->query($sql);

if (isset($_GET['category2'])) {
    $categoryId = $_GET['category'];
    // Thực hiện truy vấn để lấy danh sách sản phẩm tương ứng với categoryId
    $find = "SELECT  Categories.category_id,Categories.category_name,Products.product_id, Products.name_sp, Products.discount, Products.img
        FROM Categories 
        INNER JOIN Products ON Categories.category_id = Products.category_id 
    WHERE Categories.category_id = $categoryId";
    $result4 = $conn->query($find);
    $list = $result4->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&family=Ruslan+Display&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="./stylesheet/products.css">

    <title>Product</title>

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

            <div class="header2">
                <div class="logo">

                    <h1><?php echo $list2['title']; ?></h1>
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
                    <input class="input" type="text">
                    <div><i class="fa-solid fa-magnifying-glass id "></i></div>
                    <div id="fa-cart-shopping"><a href="./oder.php"><i class="fa-solid fa-cart-shopping id"></a></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="name">
        <h2><strong>All PRODUCT</strong></h2>
        <div style="display: flex;">

            <form method="get" class="post">
                <select name="category" class="btn" style="background: #e9e9e9;">
                    <option>select</option>
                    <?php while ($list3 = $result3->fetch_assoc()) { ?>
                        <option value="<?php echo $list3['category_id']; ?>" <?php if (isset($_GET['category']) && $_GET['category'] == $list3['category_id']) echo "selected" ?>> <?php echo $list3['category_name'] ?> </option>
                    <?php } ?>
                </select>
                <button type="submit" class="btn btn-primary" name="category2">Get the product</button>

                <input type="text" name="find2" value="<?php if (isset($echo_find)) {
                                                            echo $echo_find;
                                                        } ?>">
                <button type="submit" name="find" style="  border-radius: 15px; width: 40px; height: 40px;border: none;background-color: gainsboro;">Find</button>

            </form>
        </div>
    </div>
    <div class="header">
        <?php if (!empty($list)) : ?>
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
            <div class="pagination">
                <?php if ($total_pages > 1) { ?>
                    <?php if ($page > 1) { ?>
                        <a href="?page=<?php echo $page - 1; ?>" class="page-link">&laquo; Previous</a>
                    <?php } else { ?>
                        <span class="disabled page-link">&laquo; Previous</span>
                    <?php } ?>
                    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                        <?php if ($i == $page) { ?>
                            <span class="active page-link"><?php echo $i; ?></span>
                        <?php } else { ?>
                            <a href="?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                        <?php } ?>
                    <?php } ?>
                    <?php if ($page < $total_pages) { ?>
                        <a href="?page=<?php echo $page + 1; ?>" class="page-link">Next &raquo;</a>
                    <?php } else { ?>
                        <span class="disabled page-link">Next &raquo;</span>
                    <?php } ?>
                <?php } ?>
            </div>

        <?php else : ?>
            <p>Không có sản phẩm nào.</p>
        <?php endif; ?>
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