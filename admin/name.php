<?php
session_start();

if (empty($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit();
}

require '../db/db.php';

if (isset($_POST['save'])) {
    $title2 = $_POST['name'];
    $title3 = $_POST['name2'];

    $img = $_POST['product_image'];

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

    // Prepare and bind the query parameter
    $stmt = $conn->prepare("INSERT INTO display (img, title2, title3) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $img, $title2, $title3);

    if ($stmt->execute()) {
        echo "Record inserted successfully";
    } else {
        echo "Error inserting record: " . $conn->error;
    }
    $stmt->close(); // Close the prepared statement
}
$conn->close(); // Close the database connection
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
                                <table style="width: 100%;">
                                    <tr>
                                        <th>t2</th>
                                        <th>
                                            <input type="text" name="name">
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>t3</th>
                                        <th>
                                            <input type="text" name="name2">
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Ảnh SP</th>
                                        <th>
                                            <input type="file" name="product_image">
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Chức năng</th>
                                        <th>
                                            <button class="btn btn-primary" type="submit" name="save">Save</button>
                                        </th>
                                    </tr>
                                </table>
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
