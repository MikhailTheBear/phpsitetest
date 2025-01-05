<?php
session_start(); // Начинаем сессию

// Уничтожаем все данные сессии
session_unset(); // Удаляем все переменные сессии
session_destroy(); // Полностью уничтожаем сессию

// Перенаправляем пользователя на страницу входа с сообщением об успешном выходе
header("Location: login.php?logout=success");
exit(); // Завершаем скрипт
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Выход</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Выход</h1>
    <p><?php echo htmlspecialchars($message); ?></p>
    <a href="login.php">Вернуться на страницу входа</a>
</body>
</html>