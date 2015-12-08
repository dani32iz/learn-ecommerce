<?php

// Отображать все ошибки
error_reporting(-1);
ini_set('display_errors', 'on');

define('CONTROLLERS_DIR', __DIR__ . '/controllers');
define('TEMPLATES_DIR', __DIR__ . '/templates');
define('HEADER_TEMPLATE_FILE', __DIR__ . '/layouts/header.php');
define('FOOTER_TEMPLATE_FILE', __DIR__ . '/layouts/footer.php');

// Подключение к БД
require_once __DIR__ . '/db.php';

// Загрузка функций
require_once __DIR__ . '/functions.php';

session_start();


if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$action = get_current_action();

$path_to_controller = CONTROLLERS_DIR . '/' . $action . '.php';

// подключим файл, которые содержит код для выбранного $action
if (file_exists($path_to_controller)) {
    require_once $path_to_controller;
} else {
    not_found_404();
}

session_write_close();