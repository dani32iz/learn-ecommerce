<?php
/**
 * Контроллер отображения полного содержимого корзины
 */

// Нам передан параметр "delete" - значит пользователь нажал на кнопку "Удалить товар"
if (isset($_POST['delete'], $_POST['product_id'])) {
    $product_id = (int) $_POST['product_id'];

    // Собственно, удаляем из сессии информацию о товаре в корзине, если он там есть
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

// Отобразим шаблон "cart", передав в него в качестве переменных
// результат вызова функции get_full_cart_data()
display_template('cart', get_full_cart_data());