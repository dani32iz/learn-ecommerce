<h3>Авторизация</h3>

<form method="POST" action="./index.php?action=login">
    <?php require __DIR__ . '/_form-errors.php'; ?>
    <p>
        <label>E-mail: <input type="text" name="email"></label>
    </p>
    <p>
        <label>Пароль: <input type="password" name="password"></label>
    </p>
    <p>
        <button type="submit">Войти</button>
    </p>
</form>