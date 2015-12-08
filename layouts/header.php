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

<ul>
    <?php foreach (get_menu_items() as $menu_item): ?>
        <li>
            <?php if ($menu_item['is_active']): ?>
                <b><?= $menu_item['title'] ?></b>
            <?php else: ?>
                <a href="<?= $menu_item['url'] ?>"><?= $menu_item['title'] ?></a>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>