<?php
session_start();
if (empty($_SESSION['loggedin'])) {
    header('Location:index1.php');
    exit();
} else {
    require '../db/db.php';
    mysqli_select_db($conn, "project");
    $errors = [];
    $thanhcong = '';

    $sql = "SELECT *FROM Categories";
    $result = $conn->query($sql);

    if (isset($_POST['submit'])) {
        $Category = $_POST['Category'];

        if (empty($Category)) {
            $errors['nhap'] = "nhập đủ thông tin !";
        }

        $sql = "SELECT COUNT(*)as count FROM Categories  WHERE category_name='$Category'";
        $result = $conn->query($sql);
        $row = mysqli_fetch_assoc($result);
        if ($row['count'] > 0) {
            $errors['nhap2'] = $Category . "    đã có tên trong danh mục vui lòng nhập tên khác!";
        }


        if (empty($errors)) {
            $sql = "SELECT * FROM Categories ";
            $result = $conn->query($sql);
            $insert_Category = "INSERT INTO Categories (category_name) VALUES ('$Category')";
            if ($conn->query($insert_Category)) {
                $result = $conn->query($sql);
                $res = mysqli_fetch_assoc($result);
                $thanhcong = "Thêm tên danh mục sản phẩm tên:" . $Category . "   thành công";
            } else {
                echo "Lỗi tên danh mục ";
            }
        }
    }
   
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
    <title>Tables - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

</head>

<body class="sb-nav-fixed">


    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">

        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form>
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
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Products
                        </a>
                        <a class="nav-link" href="More_information.php">
                            <div class="sb-nav-link-icon"><i class="fa-sharp fa-light fa-pen"></i></div>
                            Update more products
                        </a>


                        <a class="nav-link" href="oder_table.php">
                            <div class="sb-nav-link-icon"><i class="fa-brands fa-shopify"></i></div>
                            Order Table
                        </a>
                        <a class="nav-link" href="./more.php">
                            <div class="sb-nav-link-icon"><i class="fa-sharp fa-light fa-plus"></i></div>
                            Add Category
                        </a>
                        <a class="nav-link" href="./feedback.php">
                            <div class="sb-nav-link-icon"><i class="fa-sharp fa-light fa-file-pen"></i></div>
                            Feedback
                        </a>
                        <a class="nav-link" href="./home_page.php">
                            <div class="sb-nav-link-icon"><i class="fa-sharp fa-light fa-pen"></i></div> Edit Home
                        </a>
                        <a class="nav-link" href="login_out.php">
                            <div class="sb-nav-link-icon"><i class="fa-sharp fa-light fa-right-from-bracket"></i></div>
                            Login out
                        </a>

                    </div>
                </div>
            </nav>
        </div>
        <form method="post" enctype="multipart/form-data">
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Update </h1>
                        <div class="card mb-4">

                            <div class="card-body">
                                <table style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th> Map Category Name</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" id='Category' name='Category'>
                                            </td>
                                            <td>
                                                <input type="submit" name="submit" value="Submit" class="form-control">
                                                <?php
                                                if (isset($errors['nhap'])) {
                                                    echo $errors['nhap'];
                                                }
                                                ?>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                               
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Category Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($list = $result->fetch_assoc()) { ?>
                                                <tr>
                                                    <td><?php echo $list['category_name'] ?></td>

                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>

                               
                                <div>
                                    <div>
                                        <?php
                                        echo $thanhcong;

                                        if (isset($errors['nhap2'])) {
                                            echo $errors['nhap2'];
                                        }

                                        ?>
                                    </div>

                                </div>
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