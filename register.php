<?php
// Включаем отображение ошибок
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Определяем путь к файлу пользователей
$file = 'users.txt';

// Функция для регистрации пользователя
function registerUser($username, $password, $file) {
    if (file_exists($file)) {
        $users = file($file, FILE_IGNORE_NEW_LINES);
        foreach ($users as $user) {
            list($existingUsername, $hashedPassword) = explode('|', $user);
            if ($existingUsername === $username) {
                return false; // Пользователь уже существует
            }
        }
    }

    // Хешируем пароль и записываем данные в файл
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    file_put_contents($file, "$username|$hashedPassword\n", FILE_APPEND);
    return true;
}

// Обработка отправки формы
$message = '';
$messageType = ''; // Тип сообщения (успех или ошибка)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);

    if (empty($username) || empty($password) || empty($confirmPassword)) {
        $message = "Пожалуйста, заполните все поля.";
        $messageType = 'error';
    } elseif ($password !== $confirmPassword) {
        $message = "Пароли не совпадают.";
        $messageType = 'error';
    } elseif (registerUser($username, $password, $file)) {
        $message = "Регистрация прошла успешно!";
        $messageType = 'success';
    } else {
        $message = "Пользователь с таким именем уже существует.";
        $messageType = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Регистрация:</h1>
    <form action="" method="POST">
        <label for="username">Имя пользователя:</label>
        <input type="text" name="username" required><br><br>

        <label for="password">Пароль:</label>
        <input type="password" name="password" required><br><br>

        <label for="confirm_password">Подтверждение пароля:</label>
        <input type="password" name="confirm_password" required><br><br>
        
        <button type="submit">Зарегистрироваться</button>
        
        <div class="login-link">
            <p>Уже есть аккаунт?</p>
            <a href="login.php">Войти</a>
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