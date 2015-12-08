<?php
$page = filter_input(INPUT_GET, 'page');
if ($page === null) {
    $page = 1;
}

$products_per_page = 3;

// Общее количество товаров в базе
$products_count = db_select('SELECT COUNT(*) FROM products;');
$products_count = reset($products_count);
$products_count = (int) reset($products_count);

// Кол-во товаров, которые нужно выбрать
$limit = $products_per_page;

// Кол-во товаров, которые нужно пропустить с начала выборки (сдвиг)
$offset = $products_per_page * ($page - 1);

$last_page = $products_count / $products_per_page;

$has_next_page = $last_page > $page;
$has_prev_page = $page > 1;

$products = db_select("SELECT * FROM products LIMIT {$offset}, {$limit};");

display_template('products', array(
    'products' => $products,
    'products_count' => $products_count,
    'page' => $page,
    'has_next_page' => $has_next_page,
    'has_prev_page' => $has_prev_page,
));