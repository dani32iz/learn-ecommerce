<?php if (!empty($errors)): ?>
    <div style="color: red;">
        <h4>Были допущены ошибки:</h4>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>