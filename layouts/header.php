<!DOCTYPE html>
<html>
<head>
    <title><?= $page_title ?></title>
    <meta charset="UTF-8">
</head>
<body>

<?php $cart = get_cart_data() ?>
<div>
    <h4><a href="./?action=cart">Корзина</a></h4>
    <?= $cart['quantity'] ?> товаров на сумму <?= $cart['cost'] ?>р.
</div>