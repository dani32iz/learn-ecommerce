<?php
/**
 * Контроллер добавления товара в корзину
 */

// Переданы ID товара и его количество
if (isset($_POST['product_id'], $_POST['quantity'])) {

    $product_id = (int) $_POST['product_id'];
    $quantity = (int) $_POST['quantity'];

    // Получаем из базы информацию о товаре
    $product = db_select("SELECT * FROM products WHERE id = {$product_id}");
    $product = reset($product);

    // Товар не найден в базе
    if (!$product) {
        not_found_404('Запрашиваемый товар не найден!');
    } else {
        // Доступное количество товара из базы
        $product_available_quantity = $product['quantity'];

        // $quantity - количество товара, которое будет в корзине
        // (уже имеющееся в корзине + то, что мы собираемся добавить)
        $quantity = isset($_SESSION['cart'][$product_id])
            ? $quantity + $_SESSION['cart'][$product_id]
            : $quantity;

        // Если мы собираемся иметь в корзине больше единиц товара, чем доступно,
        // то положим в корзину всё доступное количество
        if ($quantity > $product_available_quantity) {
            $quantity = $product_available_quantity;
        }

        // Собственно добавление товара в корзину
        $_SESSION['cart'][$product_id] = (int) $quantity;

        // Отправим браузеру заголовок "Location", чтобы браузер вернулся на предыдущую страницу
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}