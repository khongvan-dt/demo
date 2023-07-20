<?php
session_start();
if (empty($_SESSION['loggedin'])) {
    header('Location:login.php');
    exit();
} else {

    require '../db/db.php';
    mysqli_select_db($conn, "project");
    $errors = [];
    $thanhcong = [];

    $sql = "SELECT * FROM Categories";
    $result = $conn->query($sql);
    $list_cater = $result->fetch_all(MYSQLI_ASSOC);

    if (isset($_POST['submit'])) {
        $product_name = $_POST['product_name']; //
        $product_price = $_POST['product_price'];
        $product_image = $_FILES['product_image']['name']; //
        $img_discount = $_FILES['img_discount']['name']; //
        $price_discount = $_POST['price_discount'];
        $description = mysqli_real_escape_string($conn, $_POST['description']);

        // $description = $_POST['description'];
        $category_id = $_POST['category_id'];

        if (empty($product_name)) {
            $errors['loi1'] = 'nhập đủ';
        }
        if (empty($product_price)) {
            $errors['loi2'] = 'nhập đủ';
        }
        if (empty($product_image)) {
            $errors['loi3'] = 'nhập đủ';
        }
        if (empty($img_discount)) {
            $errors['loi4'] = 'nhập đủ';
        }
        if (empty($price_discount)) {
            $errors['loi5'] = 'nhập đủ';
        }
        if (empty($description)) {
            $errors['loi6'] = 'nhập đủ';
        }

        if (empty($errors)) {
            // Xử lý file ảnh
            $target_dir = "upload_mau/"; // thư mục để lưu trữ tạm thời ảnh
            $target_dir2 = "upload_chi_tiet/"; // thư mục để lưu trữ tạm thời ảnh


            //tạo đường dẫn file upload lên hệ thống 
            $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
            $target_file2 = $target_dir2 . basename($_FILES["img_discount"]["name"]);

            //ktra kích thức file
            if ($_FILES["product_image"]["size"] > 500000) {
                $errors[] = 'Chỉ được upload ảnh mẫu dưới 5mb </br>';
            }
            if ($_FILES["img_discount"]["size"] > 500000) {
                $errors[] = 'Chỉ được upload ảnh chi tiết file dưới 5mb </br>';
            }
            //kiem tra loại file 
            $type_file = pathinfo($_FILES["product_image"]["name"], PATHINFO_EXTENSION);
            $type_file2 = pathinfo($_FILES["img_discount"]["name"], PATHINFO_EXTENSION);

            $type_file_allow = array('jpg', 'gif', 'jpeg', 'png', 'img');
            if (!in_array(strtolower($type_file), $type_file_allow)) {
                $errors[] = 'ảnh mẫu định dạng không hợp lệ</br>';
            }
            if (!in_array(strtolower($type_file2), $type_file_allow)) {
                $errors[] = 'ảnh chi tiết định dạng không hợp lệ</br>';
            }

            //kiểm tra nếu không lỗi thì sẽ chuyển file từ bộ nhớ tạm lên server
            if (empty($errors)) {
                if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                    $thanhcong['img_mau'] = 'Upload ảnh mẫu thành công</br>';
                } else {
                    $errors['img_mau'] = 'Upload ảnh mẫu thất bại</br>';
                }
            }
            if (empty($errors)) {
                if (move_uploaded_file($_FILES["img_discount"]["tmp_name"], $target_file2)) {
                    $thanhcong['img_chi_tiet'] = 'Upload ảnh chi tiết thành công </br>';
                } else {
                    $errors['img_chi_tiet'] = 'Upload ảnh chi tiết thất bại </br>';
                }
            }

            if ($errors) {
                print_r($errors);
                exit;
            }

            if (empty($errors)) {

                // // Lấy ra id của danh mục tương ứng từ bảng Products

                $sql = "SELECT * FROM Products";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();

                $insert_product = "INSERT INTO Products (name_sp, price, discount, img, description, category_id)
                VALUES ('$product_name', $product_price, $price_discount, '$product_image', '$description',$category_id )";
                $result = $conn->query($insert_product);


                if ($result) {
                    $thanhcong['insert_product'] = "Success </br>";


                    // Lấy product_id sau khi insert thành công sản phẩm vào bảng Products
                    $product_id = mysqli_insert_id($conn);

                    // Insert ảnh sản phẩm vào bảng Galery
                    $insert_Galery = "INSERT INTO Galery (img2, product_id2)
                                      VALUES ('$img_discount', $product_id)";
                    if ($conn->query($insert_Galery)) {
                        $thanhcong['insert_Galery'] = "Thêm ảnh chi tiết sản phẩm thành công </br>";
                    } else {
                        $errors['img'] = "Lỗi thêm ảnh chi tiết sản phẩm:</br> ";
                        var_dump($insert_Galery);
                    }
                } else {
                    $errors['sp'] = "Lỗi thêm sản phẩm:</br> " . $conn->$error;
                }
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
    <title>Update more products</title>
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
                        <h1 class="mt-4">Update more products</h1>
                        <div class="card mb-4">

                            <div class="card-body">
                                <table id="datatablesSimple" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th> directory list</th>
                                            <th>product name:</th>
                                            <th>sample photo:</th>
                                            <th>detailed photos:</th>
                                            <th>import price($):</th>
                                            <th> price($):</th>
                                            <th>product details</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select name="category_id" id="category_id" class="form-control" style="width: 100px;text-align: center;">
                                                    <?php foreach ($list_cater as $value) {
                                                        echo " <option value='{$value['category_id']}'>{$value['category_name']}</option> ";
                                                    } ?>

                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id='product_name' name='product_name'>
                                                <?php
                                                if (isset($errors['loi1'])) {
                                                    echo $errors['loi1'];
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <input type="file" class="form-control" name="product_image" id="img_Galery">
                                                <?php
                                                if (isset($errors['loi2'])) {
                                                    echo $errors['loi2'];
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <input type="file" class="form-control" id="img_discount" name="img_discount">
                                                <?php
                                                if (isset($errors['loi3'])) {
                                                    echo $errors['loi3'];
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="product_price" name="product_price">
                                                <?php
                                                if (isset($errors['loi4'])) {
                                                    echo $errors['loi4'];
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="price_discount" name="price_discount">
                                                <?php
                                                if (isset($errors['loi5'])) {
                                                    echo $errors['loi5'];
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <textarea class="form-control" type="text" name="description" id="description" rows="20" cols="40"></textarea>
                                                <?php
                                                if (isset($errors['loi6'])) {
                                                    echo $errors['loi6'];
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <input type="submit" class="form-control" name="submit" value="Submit" style="width: 100px ;background: #bec7d1;">
                                            </td>

                                        </tr>

                                    </tbody>
                                </table>
                                <?php
                                // if (isset($thanhcong['insert_Galery'])) {
                                //     echo  $thanhcong['insert_Galery'];
                                // }
                                if (isset($thanhcong['insert_product'])) {
                                    echo  $thanhcong['insert_product'];
                                }


                                if (isset($errors['img_chi_tiet'])) {
                                    echo  $errors['img_chi_tiet'];
                                }

                                if (isset($errors['img_mau'])) {
                                    echo  $errors['img_mau'];
                                }

                                if (isset($errors['img'])) {
                                    echo  $errors['img'];
                                }

                                if (isset($errors['sp'])) {
                                    echo $errors['sp'];
                                }

                                ?>
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

</html>