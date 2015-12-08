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
    // В эту переменную занесём строку, содержащую идентификаторы товаров,
    // находящихся в корзине, перечисленные через запятую
    $product_ids = array_keys($_SESSION['cart']);
    $product_ids = implode(',', $product_ids);

    // Получим из БД массив с информацией о товарах, находящихся в корзине
    $products = db_select("SELECT id, price FROM products WHERE id IN ({$product_ids})");

    // Общая стоимость товаров в корзине
    $total_cost = 0;

    // Общее количество товаров в корзине
    $total_quantity = 0;

    // В цикле обойдём массив с информацией о товарах
    foreach ($products as $product) {
        // и прибавим к суммарным переменным данные о каждом товаре
        $total_quantity += $_SESSION['cart'][$product['id']];
        $total_cost += $product['price'] * $_SESSION['cart'][$product['id']];
    }

    // Вернём массив данных, которые могут быть переданы в шаблон
    return array(
        'quantity' => $total_quantity,
        'cost' => $total_cost,
    );
}

/**
 * Получение из БД и подсчёт данных, необходимых для отображения страницы с информацией о товарах в корзине/
 */
function get_full_cart_data()
{
    // В эту переменную занесём строку, содержащую идентификаторы товаров,
    // находящихся в корзине, перечисленные через запятую
    $product_ids = array_keys($_SESSION['cart']);
    $product_ids = implode(',', $product_ids);

    // Получим из БД массив с информацией о товарах, находящихся в корзине
    $products = db_select("SELECT id, title, price, quantity FROM products WHERE id IN ({$product_ids})");

    // Общая стоимость товаров в корзине
    $total_cost = 0;

    // Общее количество товаров в корзине
    $total_quantity = 0;

    // В цикле обойдём массив с информацией о товарах
    foreach ($products as &$product) {
        // Количество данного товара, находящееся в корзине
        $product_quantity_at_cart = $_SESSION['cart'][$product['id']];

        // Суммарная стоимость за всё количество данного товара в корзине
        $product_price_at_cart = $product['price'] * $product_quantity_at_cart;

        // Добавим два значения в массив с информацией о конкретном товаре:
        // quantity_at_cart - общее количество единиц товара в корзине
        // total_price_at_cart - суммарная стоимость за всё количество данного товара в корзине
        $product['quantity_at_cart'] = $product_quantity_at_cart;
        $product['total_price_at_cart'] = $product_price_at_cart;

        // прибавим к суммарным переменным данные о каждом товаре
        $total_quantity += $product_quantity_at_cart;
        $total_cost += $product_price_at_cart;
    }

    // Вернём массив данных, которые могут быть переданы в шаблон
    return array(
        'products' => $products,
        'total_quantity' => $total_quantity,
        'total_cost' => $total_cost,
    );
}

function get_current_action()
{
    // $action - действие, которое нужно выполнить
    // согласно этому действию будет выполнен файл с соответствующим именем из папки controllers
    static $action = null;

    if ($action === null) {
        $action = filter_input(INPUT_GET, 'action');

        if ($action === null) {
            // homepage - значение по-умолчанию для $action
            $action = 'homepage';
        } else {
            // обезопасим $action, убрав все компоненты пути, кроме последнего, т.е.
            // если $action = '../../hello', то $action станет 'hello'
            $action = basename($action);
        }
    }

    return $action;
}

function get_menu_items()
{
    $items = array(
        array(
            'title' => 'Домашняя страница',
            'action' => 'homepage'
        ),

        array(
            'title' => 'Список товаров',
            'action' => 'products'
        ),

        array(
            'title' => 'Корзина',
            'action' => 'cart'
        ),
    );

    foreach ($items as &$item) {
        $item['url'] = './index.php?action=' . $item['action'];
        $item['is_active'] = (get_current_action() == $item['action']);
    }

    return $items;
}