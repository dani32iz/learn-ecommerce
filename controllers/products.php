<?php
/**
 * Контроллер, отвечающий за отображение списка товаров магазина
 */

// Получаем значение параметра "page", определяющего номер текущей страницы
$page = (int) filter_input(INPUT_GET, 'page');

// По-умолчанию, если такой GET-параметр не передан или некорректен, установим значение 1
if ($page <= 0) {
    $page = 1;
}

// Количество товаров на страницу
$products_per_page = 3;

// Общее количество товаров в базе
$products_count = db_select('SELECT COUNT(*) FROM products;');
$products_count = reset($products_count);
$products_count = (int) reset($products_count);

// Кол-во товаров, которые нужно выбрать
$limit = $products_per_page;

// Кол-во товаров, которые нужно пропустить с начала выборки (сдвиг)
$offset = $products_per_page * ($page - 1);

// Определим номер последней страницы
$last_page = $products_count / $products_per_page;

// Есть ли следующая страница
$has_next_page = $last_page > $page;

// Есть ли предыдущая страница
$has_prev_page = $page > 1;

// Получим из БД список товаров, ограниченный значениями limit и offset
$products = db_select("SELECT * FROM products LIMIT {$offset}, {$limit};");

// Отобразим шаблон, передав в него необходимые переменные
display_template('products', array(
    'products' => $products,
    'products_count' => $products_count,
    'page' => $page,
    'has_next_page' => $has_next_page,
    'has_prev_page' => $has_prev_page,
));