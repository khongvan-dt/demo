<?php
session_start();

if (empty($_SESSION['loggedin'])) {
  header('Location:login.php');
  exit();
}

require '../db/db.php';

mysqli_select_db($conn, "project");
$sql2 = "SELECT 
        Orders.User_id, User.user_name, Orders.order_id, Orders.fullname, Orders.phone_number,
        Orders.address, Orders.note, SUM(Order_Details.total_money) as total_money
        FROM Order_Details 
        INNER JOIN Orders 
        ON Order_Details.order_id = Orders.order_id 
        INNER JOIN User 
        ON Orders.User_id = User.User_id 
        GROUP BY Order_Details.order_id";
$result2 = $conn->query($sql2);

$i = 0;

if (isset($_POST['find'])) {
  $write = $_POST['find2'];
  $find = "SELECT DISTINCT
  Orders.order_id,
  Orders.fullname,
  Orders.phone_number,
  Orders.address,
  Orders.note,
  Order_Details.total_money
FROM   Order_Details
  INNER JOIN Orders
          ON Order_Details.order_id = Orders.order_id
  INNER JOIN Products
          ON Order_Details.product_id = Products.product_id
WHERE  Orders.fullname LIKE '%$write%'
  OR Orders.phone_number LIKE '%$write%'
  OR Orders.address LIKE '%$write%'
  OR Orders.note LIKE '%$write%'
  OR Order_Details.total_money LIKE '%$write%'
GROUP  BY Order_Details.order_id";
  $result = $conn->query($find);
  $list = $result->fetch_all(MYSQLI_ASSOC);


  while ($row = $result2->fetch_assoc()) {
    $order_id = $row['order_id'];
    $sql2 = "SELECT Order_Details.order_id, Products.name_sp, 
        Products.discount, Order_Details.num
        FROM Order_Details
        INNER JOIN Products 
            ON Order_Details.product_id = Products.product_id
        WHERE Order_Details.order_id ='$order_id'
        AND ( Products.name_sp LIKE '%$write%' 
          OR Products.discount LIKE '%$write%'
          OR Order_Details.num LIKE '%$write%')
      GROUP BY Order_Details.order_id";

    $result2 = $conn->query($sql2);
    $list2 = $result->fetch_all(MYSQLI_ASSOC);
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
  <title>Order List</title>
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
  <link href="css/styles.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">

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
          <div class="card mb-4">
            <h1 class="mt-4">Order List</h1>


            <div class="card-body">
              <table id="datatablesSimple" style="width: 100%;">
                <thead>
                  <tr>
                    <th>STT</th>
                    <th>User Name</th>
                    <th>Customer name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Product's name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>note</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($row = $result2->fetch_assoc()) : $i++; ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $row['user_name']; ?></td>
                      <td><?php echo $row['fullname']; ?></td>
                      <td><?php echo $row['phone_number']; ?></td>
                      <td><?php echo $row['address']; ?></td>
                      <td>
                        <?php
                        $order_id = $row['order_id'];
                        $sql = "SELECT Order_Details.order_id, Products.name_sp, 
                              Products.discount, Products.img, Order_Details.num
                              FROM Order_Details
                              INNER JOIN Products 
                                  ON Order_Details.product_id = Products.product_id
                              WHERE Order_Details.order_id ='$order_id'";
                        $result = $conn->query($sql);
                        while ($product_row = $result->fetch_assoc()) {
                          echo $product_row['name_sp'] . '<br/>';
                        }
                        ?>
                      </td>

                      <td>
                        <?php
                        $result = $conn->query($sql);
                        while ($product_row = $result->fetch_assoc()) {
                          echo $product_row['discount'] . '$' . '<br/>';
                        }
                        ?>
                      </td>
                      <td>
                        <?php
                        $result = $conn->query($sql);
                        while ($product_row = $result->fetch_assoc()) {
                          echo $product_row['num'] . '<br/>';
                        }
                        ?>
                      </td>
                      <td><?php echo $row['note']; ?></td>
                      <td><?php echo $row['total_money'] . '$'; ?></td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
  <script src="js/datatables-simple-demo.js"></script>
</body>

</html>