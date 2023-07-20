<?php
session_start();

if (empty($_SESSION['loggedin'])) {
    header('Location:login.php');
    exit();
}

require '../db/db.php';

$sql = "SELECT Categories.category_id, Categories.category_name,Products.product_id, Products.name_sp, Products.price, Products.discount, Products.img, Products.description, Galery.img2,Galery.product_id2
    FROM Categories
    INNER JOIN Products ON Categories.category_id = Products.category_id
    INNER JOIN Galery ON Galery.product_id2 = Products.product_id";

$result = $conn->query($sql);

if (isset($_POST['find'])) {
    $write = $_POST['find2'];
    $find = "SELECT DISTINCT Categories.category_id, Categories.category_name,Products.product_id, Products.name_sp, Products.price, Products.discount, Products.img, Products.description, Galery.img2,Galery.product_id2
    FROM Categories
    INNER JOIN Products ON Categories.category_id = Products.category_id
    INNER JOIN Galery ON Galery.product_id2 = Products.product_id 
    WHERE Categories.category_name LIKE '%$write%' OR Products.name_sp LIKE '%$write%' OR Products.discount LIKE '%$write%' OR Products.description LIKE '%$write%' OR Products.price LIKE '%$write%'";
    $result = $conn->query($find);
}

if (isset($_POST['xoa'])) {
    $productId = $_POST['productId'];

    $sqlDeleteGalery = "DELETE FROM Galery WHERE product_id2='$productId'";
    $conn->query($sqlDeleteGalery);

    $sqlDeleteProduct = "DELETE FROM Products WHERE product_id='$productId'";
    if ($conn->query($sqlDeleteProduct) === true) {
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit();
    } else {
        echo "Lỗi khi xóa sản phẩm: " . mysqli_error($conn);
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
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <form method="post">
        <?php if (!empty($result)) : ?>
            <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
                <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
                <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0" method="post">
                    <div class="input-group">
                        <input type="text" name="find2" class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                        <button class="btn btn-primary" id="btnNavbarSearch" type="submit" name="find"><i class="fas fa-search"></i></button>
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
                <div id="layoutSidenav_content">
                    <main>
                        <div class="container-fluid px-4">
                            <div>
                                <h1 class="mt-4">List of products</h1>


                                <div class="card-body">
                                    <table id="datatablesSimple" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name Products</th>
                                                <th>Product's Name</th>
                                                <th>Image Product</th>
                                                <th>Product Detail Photos</th>
                                                <th>Entry Price</th>
                                                <th>Price</th>
                                                <th>Detailed Product Description</th>
                                                <th>Function</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 0;
                                            while ($row = $result->fetch_assoc()) {
                                                $i++; ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $i; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['category_name']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['name_sp']; ?>
                                                    </td>
                                                    <td><img src="./upload_mau/<?php echo $row['img']; ?>" alt="<?php echo $row['name_sp']; ?>" width="150px" height="100px"></td>
                                                    <td><img src="./upload_chi_tiet/<?php echo $row['img2']; ?>" alt="<?php echo $row['name_sp']; ?>" width="150px" height="100px"></td>
                                                    <td>
                                                        <?php echo $row['price'] . '$'; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['discount'] . '$'; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['description']; ?>
                                                    </td>
                                                    <td>
                                                        <form method="post">
                                                            <input type="hidden" name="category_name" value="<?php echo $row['category_name']; ?>">
                                                            <input type="hidden" name="img2" value="<?php echo $row['img2']; ?>">
                                                            <input type="hidden" name="Galery.product_id" value="<?php echo $row['product_id2']; ?>">
                                                            <input type="hidden" name="productId" value="<?php echo $row['product_id']; ?>">
                                                            <input type="hidden" name="price" value="<?php echo $row['name_sp']; ?>">
                                                            <input type="hidden" name="brandName" value="<?php echo $row['img']; ?>">
                                                            <input type="hidden" name="detailImg" value="<?php echo $row['img2']; ?>">
                                                            <input type="hidden" name="importPrice" value="<?php echo $row['price']; ?>">
                                                            <input type="hidden" name="salePrice" value="<?php echo $row['discount']; ?>">
                                                            <input type="hidden" name="description" value="<?php echo $row['description']; ?>">
                                                            <button type="submit" name="xoa" value="xoa" class="btn btn-primary">Delete</button>

                                                        </form>
                                                        <a href="./edit.php?product_id=<?php echo $row['product_id']; ?>" class="btn btn-primary">Edit</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                <?php else : ?>
                                    <p>No products.</p>
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

</html>