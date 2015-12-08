<?php
if (isset($_POST['delete'], $_POST['product_id'])) {
    $product_id = (int) $_POST['product_id'];

    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

display_template('cart', get_full_cart_data());