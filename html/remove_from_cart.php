<?php
session_start();

if (isset($_POST['product_id'])) {
    $id = intval($_POST['product_id']);

    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
}

header("Location: view_cart.php");
exit;
