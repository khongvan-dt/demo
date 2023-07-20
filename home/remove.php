<?php
session_start();

if (empty($_SESSION['login'])) {
    header('Location:login.php');
    exit();
}

if (isset($_POST["product_id"])) {
    $product_id = $_POST["product_id"];
    $user_id = $_SESSION['User_id'];
    if (isset($_SESSION["cart"][$user_id][$product_id])) {
        unset($_SESSION["cart"][$user_id][$product_id]);
        if (empty($_SESSION["cart"][$user_id])) {
            unset($_SESSION["cart"][$user_id]);
        }
        header('Location:oder.php');
        exit();
    } else {
        echo "Product not found in cart!";
    }
} else {
    echo "Product ID not specified!";
}
?>
