<?php
session_start();

if (isset($_POST['product_id']) && isset($_POST['action'])) {
    $id = $_POST['product_id'];
    $action = $_POST['action'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if ($action === 'increase') {
        $_SESSION['cart'][$id] = isset($_SESSION['cart'][$id]) ? $_SESSION['cart'][$id] + 1 : 1;
    } elseif ($action === 'decrease') {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]--;
            if ($_SESSION['cart'][$id] <= 0) {
                unset($_SESSION['cart'][$id]);
            }
        }
    }

    echo json_encode(['success' => true, 'newQty' => $_SESSION['cart'][$id] ?? 0]);
    exit;
}
echo json_encode(['success' => false]);
