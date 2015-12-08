<?php
/**
 * Контроллер добавления товара в корзину
 */

if (isset($_POST['product_id'], $_POST['quantity'])) {
    $product_id = (int) $_POST['product_id'];
    $quantity = (int) $_POST['quantity'];

    $product = db_select("SELECT * FROM products WHERE id = {$product_id}");
    $product = reset($product);

    if (!$product) {
        not_found_404('Запрашиваемый товар не найден!');
    } else {
        $product_available_quantity = $product['quantity'];

        $quantity = isset($_SESSION['cart'][$product_id])
            ? $quantity + $_SESSION['cart'][$product_id]
            : $quantity;

        if ($quantity > $product_available_quantity) {
            $quantity = $product_available_quantity;
        }

        $_SESSION['cart'][$product_id] = (int) $quantity;

        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}