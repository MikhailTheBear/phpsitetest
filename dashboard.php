<?php
session_start();

// Проверяем, вошел ли пользователь
if (!isset($_SESSION['username'])) {
    // Отправляем HTTP-статус 403 (запрещено)
    http_response_code(403);
    ?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>403 | Нет доступа</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background: linear-gradient(135deg, #ff8800, #ff6f00);
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }

            .error-container {
                text-align: center;
                background: #fff;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .error-container h1 {
                font-size: 96px;
                color: #e74c3c;
                margin: 0;
            }

            .error-container p {
                font-size: 18px;
                color: #555;
            }

            .error-container a {
                color: #ff6f00;
                text-decoration: none;
                font-size: 16px;
                padding: 10px 20px;
                border: 1px solid #ff6f00;
                border-radius: 5px;
                transition: 0.3s;
            }

            .error-container a:hover {
                background: #ff6f00;
                color: #fff;
            }
        </style>
    </head>
    <body>
        <div class="error-container">
            <h1>403</h1>
            <p>Нет доступа к этой странице. Пожалуйста, <a href="login.php">войдите</a>.</p>
        </div>
    </body>
    </html>
    <?php
    exit(); // Завершаем скрипт
}

// Если пользователь вошел, показываем основную панель управления
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Панель управления</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #ff8800, #ff6f00);;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
            padding: 20px;
        }

        header {
            background: #35424a;
            color: #ffffff;
            padding: 10px 0;
            text-align: center;
        }

        h1 {
            margin: 0;
        }

        .welcome {
            padding: 20px;
            background: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            margin: 20px 0;
            text-align: center;
        }

        .logout {
            background: #e74c3c;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s;
            display: inline-block;
            margin-top: 20px;
        }

        .logout:hover {
            background: #c0392b;
        }
    </style>
</head>
<body>
    <header>
        <h1>Панель управления</h1>
    </header>

    <div class="container">
        <div class="welcome">
            <h2>Добро пожаловать, <?php echo htmlspecialchars($username); ?>!</h2>
            <p>Вы успешно вошли в систему.</p>
            <a class="logout" href="logout.php">Выйти</a>
        </div>
    </div>
</body>
</html>