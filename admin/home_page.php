<?php
session_start();

if (empty($_SESSION['loggedin'])) {
    header('Location:login.php');
    exit();
}

require '../db/db.php';

mysqli_select_db($conn, "project");

$sql = "SELECT * FROM name_shop";
$result = $conn->query($sql);
$list_cater = $result->fetch_assoc();

$sql2 = "SELECT * FROM display";
$result2 = $conn->query($sql2);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Edit the shop homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <form method="post">
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
                            <!-- <a class="nav-link" href="./name.php">
                                <div class="sb-nav-link-icon"><i class="fa-sharp fa-light fa-pen"></i></div> them
                            </a> -->
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
                            <h1 class="mt-4">Edit The Shop Homepage</h1>


                            <div class="card-body">

                                <table>
                                    <tr>
                                        <th>Name Shop</th>
                                        <th>
                                            Logo Photo
                                        </th>
                                    </tr>
                                    <tr>

                                        <td>
                                            <?php echo $list_cater['title']; ?>
                                        </td>
                                        <td><img src="./upload/<?php echo $list_cater['img_t']; ?>" width="150px" height="100px"></td>
                                        <td>
                                            <input type="hidden" name="description" value="<?php echo $list_cater['id']; ?>">
                                            <a href="./edit_name.php?id=<?php echo $list_cater['id']; ?>" class="btn btn-primary">Edit</a>
                                        </td>
                                    </tr>


                                </table>


                                <table id="" style="width: 100%;">
                                    <tr>
                                        <th>Photo</th>
                                        <th>Title</th>
                                        <th>Detail</th>

                                    </tr>
                                    <?php
                                    while ($list_cater2 = $result2->fetch_assoc()) { ?>
                                        <tr>
                                            <td><img src="./upload/<?php echo $list_cater2['img']; ?>" width="150px" height="100px"></td>

                                            <td>
                                                <?php echo $list_cater2['title2']; ?>
                                            </td>


                                            <td>
                                                <?php echo $list_cater2['title3']; ?>
                                            </td>
                                            <td>
                                                <input type="hidden" name="description" value="<?php echo $list_cater['id']; ?>">
                                                <a href="./edit_page.php?id_s=<?php echo $list_cater2['id']; ?>" class="btn btn-primary">Edit</a>
                                            </td>
                                        </tr>
                                    <?php     }
                                    ?>



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