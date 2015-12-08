<?php

/**
 * Эта функция отображает шаблон 404-й страницы с заданным текстом
 */
function not_found_404($message = 'Страница не найдена!')
{
    display_template('404', array(
        'message' => $message,
        'page_title' => $message,
    ));
}

/**
 * Эта функция отображает шаблон и передаёт в него переменные из массива
 */
function display_template($template_name, $variables = array())
{
    if (empty($variables['page_title'])) {
        $variables['page_title'] = 'Интернет-магазин';
    }

    $template_name = basename($template_name);
    ob_start();
    extract($variables);
    unset($variables);
    require_once HEADER_TEMPLATE_FILE;
    require_once TEMPLATES_DIR . '/' . $template_name . '.php';
    require_once FOOTER_TEMPLATE_FILE;
    ob_end_flush();
}

/**
 * Получение из БД и подсчёт данных, необходимых для отображения блока
 * "Корзина" в шапке сайта.
 */
function get_cart_data()
{
    $product_ids = array_keys($_SESSION['cart']);
    $product_ids = implode(',', $product_ids);

    $products = db_select("SELECT id, price FROM products WHERE id IN ({$product_ids})");

    $total_cost  = 0;
    $total_quantity = 0;

    foreach ($products as $product) {
        $product_id = $product['id'];

        $total_quantity += $_SESSION['cart'][$product_id];
        $total_cost += $product['price'] * $_SESSION['cart'][$product_id];
    }

    return array(
        'quantity' => $total_quantity,
        'cost' => $total_cost,
    );
}

function get_full_cart_data()
{
    $product_ids = array_keys($_SESSION['cart']);
    $product_ids = implode(',', $product_ids);

    $products = db_select("SELECT id, title, price, quantity FROM products WHERE id IN ({$product_ids})");

    $total_cost  = 0;
    $total_quantity = 0;

    foreach ($products as &$product) {
        $product_id = $product['id'];

        $product_quantity_at_cart = $_SESSION['cart'][$product_id];
        $product_price_at_cart = $product['price'] * $product_quantity_at_cart;

        $product['quantity_at_cart'] = $product_quantity_at_cart;
        $product['total_price_at_cart'] = $product_price_at_cart;

        $total_quantity += $product_quantity_at_cart;
        $total_cost += $product_price_at_cart;
    }

    return array(
        'products' => $products,
        'total_quantity' => $total_quantity,
        'total_cost' => $total_cost,
    );
}