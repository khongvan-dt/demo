<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "";
$conn = mysqli_connect($servername, $username, $password);

if ($conn->connect_error) {
    die('login fail' . $conn->connect_error);
}

// Tạo cơ sở dữ liệu
$CREATE_db = "CREATE DATABASE if not exists project";
if ($conn->query($CREATE_db) === false) {
    echo "Lỗi khi tạo cơ sở dữ liệu: " . mysqli_error($conn);
}
// Chọn cơ sở dữ liệu
mysqli_select_db($conn, "project");

$create_table_users = 'CREATE TABLE IF NOT EXISTS users_admin(
    USERNAME VARCHAR (100) UNIQUE,
    PASSWORD_HASH VARCHAR (40)
  )';
if ($conn->query($create_table_users) === false) {
    echo '</br> tao table thất bại';
}
// user bảng ng dùng 
$sql = "CREATE TABLE if not exists User (
    User_id INT AUTO_INCREMENT PRIMARY KEY not null,
    user_name  VARCHAR(50)  not null,
    email varchar(150) not null,
    phone_number varchar(20) not null,
    password varchar(40) not null
    )";
if ($conn->query($sql) === false) {
    echo "Lỗi khi tạo bảng User : " . mysqli_error($conn);
}
// Tạo bảng Categories  tên danh mục đồ phòng khách ,phòng ngủ…
$sql = "CREATE TABLE if not exists Categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(255)   
)";
if ($conn->query($sql) === false) {
    echo "Lỗi khi tạo bảng Categories : " . mysqli_error($conn);
}
// Tạo bảng Products  sản phẩm
$sql = "CREATE TABLE if not exists Products (
    product_id INT AUTO_INCREMENT PRIMARY KEY ,
    category_id int not null,
    name_sp varchar(250) not null,
    price int not null, 
    discount INT not null, 
    img varchar(500) not null,
    description LONGTEXT not null,
    FOREIGN KEY (category_id) REFERENCES Categories(category_id)

)";
if ($conn->query($sql) === false) {
    echo "Lỗi khi tạo bảng Products : " . mysqli_error($conn);
}

//Table Galery //bảng ảnh của từng sp
$sql = "CREATE TABLE if not exists Galery (
    Galery_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id2 int not null,
    img2 VARCHAR(500) not null ,
    FOREIGN KEY (product_id2) REFERENCES Products(product_id)
)";
if ($conn->query($sql) === false) {
    echo "Lỗi khi tạo bảng Galery : " . mysqli_error($conn);
}
// Tạo bảng FeedBack
$sql = "CREATE TABLE if not exists FeedBack (
    id INT AUTO_INCREMENT PRIMARY KEY,
    User_id INT  NOT NULL,
    fullname varchar(30),
    email varchar(250),
    phone_number varchar(20),
    subject_name varchar(350),
    note varchar(1000),
    FOREIGN KEY (User_id) REFERENCES User(User_id)
   
)";
if ($conn->query($sql) === false) {
    echo "Lỗi khi tạo bảng FeedBack : " . mysqli_error($conn);
}

// Tạo bảng Orders
$sql = "CREATE TABLE if not exists Orders (

    order_id INT AUTO_INCREMENT PRIMARY KEY,
    User_id INT  NOT NULL,
    fullname varchar(50) not null,
    phone_number varchar(20) not null,
    address varchar(200) not null,
    note varchar(1000),
    order_date datetime ,
    status int,
     FOREIGN KEY (user_id) REFERENCES User(User_id)
    )";
if ($conn->query($sql) === false) {
    echo "Lỗi khi tạo bảng Orders : " . mysqli_error($conn);
}
//Order_Details 
$sql = "CREATE TABLE if not exists Order_Details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id int not null,
    product_id int not null,
    num int not null,
    total_money int not null,
    FOREIGN KEY (order_id) REFERENCES Orders(order_id),
    FOREIGN KEY (product_id) REFERENCES Products(product_id)
)";
if ($conn->query($sql) === false) {
    echo "Lỗi khi tạo bảng Order_Details : " . mysqli_error($conn);
}

$sql = "CREATE TABLE if not exists name_shop (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title varchar(50),
    img_t varchar(50) 

)";
if ($conn->query($sql) === false) {
    echo "Lỗi khi tạo bảng display : " . mysqli_error($conn);
}

$sql = "CREATE TABLE if not exists display (
    id INT AUTO_INCREMENT PRIMARY KEY,
    img varchar(255) ,
    title2 varchar(500) ,
    title3 varchar(500) 

)";
if ($conn->query($sql) === false) {
    echo "Lỗi khi tạo bảng display : " . mysqli_error($conn);
}

