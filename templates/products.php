<h3>Товары</h3>
<h6>Найдено: <?= $products_count ?></h6>
<?php foreach ($products as $product): ?>
    <div>
        <h4><?= $product['title'] ?></h4>
        <p><b>Цена: <?= $product['price'] ?>р.</b></p>
        <p><b>На складе: <?= $product['quantity'] ?></b></p>
        <p><?= $product['description'] ?></p>
        <form action="./?action=add_to_cart" method="POST">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?> ">
            <label for="quantity_<?= $product['id'] ?>">Количество</label>
            <input id="quantity_<?= $product['id'] ?>" type="text" name="quantity" value="1">
            <button type="submit">Добавить в корзину</button>
        </form>
    </div>
    <hr>
<?php endforeach; ?>

<?php if ($has_next_page): ?>
    <a href="./?action=products&page=<?= $page + 1 ?>">Вперёд &rarr;</a><br>
<?php endif; ?>

<?php if ($has_prev_page): ?>
    <a href="./?action=products&page=<?= $page - 1 ?>">&larr; Назад</a>
<?php endif; ?>
