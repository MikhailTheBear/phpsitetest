<?php
// Включаем отображение ошибок
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Определяем путь к файлу пользователей
$file = 'users.txt';

// Функция для проверки имени пользователя и пароля
function checkCredentials($username, $password, $file) {
    if (!file_exists($file)) return false;

    $users = file($file, FILE_IGNORE_NEW_LINES);
    foreach ($users as $user) {
        list($existingUsername, $hashedPassword) = explode('|', $user);
        if ($existingUsername === $username && password_verify($password, $hashedPassword)) {
            return true;
        }
    }
    return false;
}

// Обработка отправки формы
$message = '';
$messageType = ''; // Тип сообщения (успех или ошибка)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $message = "Пожалуйста, заполните все поля.";
        $messageType = 'error';
    } elseif (checkCredentials($username, $password, $file)) {
        $_SESSION['username'] = $username;
        $message = "Вход выполнен успешно!";
        $messageType = 'success';

        // Перенаправление на dashboard.php через 1 секунду
        header("Refresh: 1; url=dashboard.php");
        exit(); // Завершаем скрипт, чтобы предотвратить дальнейшую обработку
    } else {
        $message = "Неверное имя пользователя или пароль.";
        $messageType = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Вход:</h1>
    <form action="" method="POST">
        <label for="username">Имя пользователя:</label>
        <input type="text" name="username" required><br><br>

        <label for="password">Пароль:</label>
        <input type="password" name="password" required><br><br>
        
        <button type="submit">Войти</button>
        
        <div class="register-link">
            <p>Ещё нет аккаунта?</p>
            <a href="register.php">Зарегистрироваться</a>
        </div>
    </form>

    <!-- Всплывающее уведомление -->
    <?php if ($message): ?>
        <div class="notification <?php echo $messageType; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <!-- Скрипт для автоматического скрытия уведомления -->
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const notification = document.querySelector('.notification');
            if (notification) {
                // Показать уведомление
                notification.classList.add('show');
                
                // Удалить уведомление через 3 секунды
                setTimeout(() => {
                    notification.classList.remove('show');
                    notification.classList.add('hide');
                    setTimeout(() => notification.remove(), 600); // Удаление элемента
                }, 3000);
            }
        });
    </script>
</body>
</html>