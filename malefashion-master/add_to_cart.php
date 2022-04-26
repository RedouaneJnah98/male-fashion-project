<?php
// start session
session_start();

// get the product ID
$id = $_GET['id'] ?? '';
$quantity = $_GET['quantity'] ?? 1;
$page = $_GET['page'] ?? 1;

// make quantity a minimum of 1
$quantity = $quantity <= 0 ? 1 : $quantity;

// add new item to the cart
$cart_item = [
    'quantity' => $quantity
];

/*
 * check if the cart session array was created
 * if it is NOT, create the cart session array
 */
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// check if the item is in the array, if it is, do not add
if (array_key_exists($id, $_SESSION['cart'])) {
    // redirect to product list and tell the user it was added to cart
    header('Location: shop.php?action=exists&id=' . $id . '&page=' . $page);
} // else, add the item to the cart/array
else {
    $_SESSION['cart'][$id] = $cart_item;

    // redirect to product list and tell the user it was added to the cart
    header('Location: shop.php?action=added&page=' . $page);
}
