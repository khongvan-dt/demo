<?php
session_start();

if (empty($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit();
}

require '../db/db.php';

$productId = $_GET['product_id'];
$sql = "SELECT * FROM Categories";
$result = $conn->query($sql);
$list_cater = $result->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT Categories.category_id, Categories.category_name,Products.product_id, Products.name_sp, Products.price, Products.discount, Products.img, Products.description, Galery.img2,Galery.product_id2
    FROM Categories
    INNER JOIN Products ON Categories.category_id = Products.category_id
    INNER JOIN Galery ON Galery.product_id2 = Products.product_id
    WHERE Products.product_id=  $productId ";

$result2 = $conn->query($sql);
$row = $result2->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['save'])) {
    $category_id = $_POST['category_id'];
    $nameSP = $_POST['name_sp'];
    $importPrice = $_POST['import_price'];
    $salePrice = $_POST['sale_price'];
    // $description = $_POST['description'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $img = $row[0]['img'];
    if (!empty($_FILES["product_image"]["tmp_name"])) {
        $target_dir = "upload_mau/";
        $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["product_image"]["tmp_name"]);

        if ($check !== false) {
            if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {
                if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                    $img = basename($_FILES["product_image"]["name"]);
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            }
        } else {
            echo "File is not an image.";
        }
    }

    $img2 = $row[0]['img2'];
    if (!empty($_FILES["img_discount"]["tmp_name"])) {
        $target_dir = "upload_chi_tiet/";
        $target_file = $target_dir . basename($_FILES["img_discount"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["img_discount"]["tmp_name"]);

        if ($check !== false) {
            if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {
                if (move_uploaded_file($_FILES["img_discount"]["tmp_name"], $target_file)) {
                    $img2 = basename($_FILES["img_discount"]["name"]);
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            }
        } else {
            echo "File is not an image.";
        }
    }

    $sqlUpdateProduct = "UPDATE Products SET 
        category_id='$category_id',
        name_sp='$nameSP',
        price='$importPrice',
        discount='$salePrice',
        img='$img',
        description='$description'
        WHERE product_id='$productId'";


    if ($conn->query($sqlUpdateProduct) === true) {
        $sqlUpdateGallery1 = "UPDATE Galery SET img2='$img2' WHERE product_id2='$productId'";
        $conn->query($sqlUpdateGallery1);

        echo '<script>';
        echo 'var result = confirm("You have successfully fixed it!");';
        echo 'if (result) { window.location.href = "products.php"; }';
        echo '</script>';
        exit(); 
    } else {
        echo "Lỗi khi cập nhật thông tin sản phẩm: " . mysqli_error($conn);
    }
}
$conn->close();
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tables</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        input {
            width: 500px;
            border-color: whitesmoke;
            border-radius: 10px;
            padding: 10px;
        }

        h1 {
            text-align: center;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <form action="#" method="post" enctype="multipart/form-data">
        <?php if (!empty($result)) : ?>
            <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
                <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

                <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="login_out.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <div id="layoutSidenav">
                <div id="layoutSidenav_nav">
                    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                        <div class="sb-sidenav-menu">
                            <div class="nav">
                                <a class="nav-link" href="products.php">
                                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div> Products
                                </a>
                                <a class="nav-link" href="More_information.php">
                                    <div class="sb-nav-link-icon"><i class="fas fa-pen"></i></div> Update more products
                                </a>
                                <a class="nav-link" href="oder_table.php">
                                    <div class="sb-nav-link-icon"><i class="fa fa-shopify"></i></div> Order Table
                                </a>
                                <a class="nav-link" href="feedback.php">
                                    <div class="sb-nav-link-icon"><i class="fas fa-question"></i></div> Feedback
                                </a>
                                <a class="nav-link" href="./edit_home.php">
                                    <div class="sb-nav-link-icon"><i class="fas fa-question"></i></div> Edit Home
                                </a>
                                <a class="nav-link" href="login_out.php">
                                    <div class="sb-nav-link-icon"><i class="fa fa-right-from-bracket"></i></div> Login out
                                </a>
                            </div>
                        </div>
                    </nav>
                </div>

                <div id="layoutSidenav_content">
                    <h1>Edit</h1>
                    <main>
                        <div class="container-fluid px-4">
                            <div class="card mb-4">


                                <div class="card-body">
                                    <table id="" style="width: 100%;">
                                        <tr>
                                            <th> Danh mục sản phẩm </th>
                                            <th>
                                                <select name="category_id" id="category_id" class="form-control" style="width: 100px;text-align: center;">
                                                    <?php foreach ($list_cater as $value) {
                                                        echo " <option value='{$value['category_id']}'>{$value['category_name']}</option> ";
                                                    } ?>

                                                </select>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Tên SP</th>
                                            <th>
                                                <input type="text" name="name_sp" value="<?php echo $row[0]['name_sp']; ?>">
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Ảnh SP</th>
                                            <th>
                                                <input type="file" name="product_image">

                                                <img src="./upload_mau/<?php echo $row[0]['img']; ?>" alt="<?php echo $row[0]['name_sp']; ?>" width="150px" height="100px">

                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Ảnh chi tiết SP</th>
                                            <th>
                                                <input type="file" name="img_discount">

                                                <img src="./upload_chi_tiet/<?php echo $row[0]['img2']; ?>" alt="<?php echo $row[0]['name_sp']; ?>" width="150px" height="100px">
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Giá nhập vào</th>
                                            <th>
                                                <input type="text" name="import_price" value="<?php echo $row[0]['price']; ?>">
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Giá bán</th>
                                            <th>
                                                <input type="text" name="sale_price" value="<?php echo $row[0]['discount']; ?>">
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Chi tiết mô tả sản phẩm</th>
                                            <th>
                                                <textarea class="form-control" type="text" name="description" id="description" rows="15" cols="40"><?php echo $row[0]['description']; ?></textarea>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Chức năng</th>
                                            <th>
                                                <button class="btn btn-primary" type="submit" name="save">Save</button>
                                            </th>
                                        </tr>

                                    </table>
                                <?php else : ?>
                                    <p>Không có sản phẩm nào.</p>
                                <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>