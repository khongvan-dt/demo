<?php
session_start();

if (empty($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit();
}
require '../db/db.php';

$Id_s = $_GET['id_s'];

$sql2 = "SELECT * FROM display WHERE id='$Id_s'";
$result2 = $conn->query($sql2);
$list_cater2 = $result2->fetch_assoc();

if (isset($_POST['edit'])) {
    $title3 = $_POST['title3'];
    $title2 = $_POST['title2'];
    $img = $list_cater2['img'];

    if (!empty($_FILES["product_image"]["tmp_name"])) {
        $target_dir = "upload/";
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


    $sqlUpdate = "UPDATE display SET 
            title3='$title3',
            title2='$title2',
            img='$img'
            WHERE id='$Id_s'";

    if ($conn->query($sqlUpdate) === true) {
        echo '<script>';
        echo 'var result = confirm("Bạn đã sửa thành công!");';
        echo 'if (result) { window.location.href = "home_page.php"; }';
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
                <h1>Edit shop</h1>
                <main>
                    <div class="container-fluid px-4">
                        <div class="card mb-4">


                            <div class="card-body">
                                <form enctype="multipart/form-data">
                                    <table style="width: 100%;">
                                        <tr>
                                            <th>Ảnh</th>
                                            <th>
                                                <input type="file" name="product_image">
                                                <?php if ($list_cater2['img']) { ?>
                                                    <img src="./upload/<?php echo $list_cater2['img']; ?>" width="150px" height="100px">
                                                <?php } ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Tiêu đề</th>
                                            <th>
                                                <input type="text" name="title2" value="<?php echo $list_cater2['title2']; ?>">
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Chi tiết</th>
                                            <th>
                                                <input type="text" name="title3" value="<?php echo $list_cater2['title3']; ?>">
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Chức năng</th>
                                            <th>
                                                <button class="btn btn-primary" type="submit" name="edit">Save</button>
                                            </th>
                                        </tr>
                                    </table>
                                </form>
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