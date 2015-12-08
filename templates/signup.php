<h3>Регистрация</h3>
<form method="POST" action="./index.php?action=signup">
    <?php require __DIR__ .'/_form-errors.php'; ?>
    <p>
        <label>E-mail: <input type="text" name="email"></label>
    </p>
    <p>
        <label>Пароль: <input type="password" name="password"></label>
    </p>
    <p>
        <button type="submit">Зарегистрироваться</button>
    </p>
</form>