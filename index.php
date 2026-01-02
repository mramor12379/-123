<?php
session_start();

// Вихід з системи
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Файл з правильними даними для входу
$credentialsFile = 'users.txt';
$message = '';

// Обробка форми
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    // Читання правильних даних з файлу
    if (file_exists($credentialsFile)) {
        $fileContent = file_get_contents($credentialsFile);
        $lines = explode("\n", trim($fileContent));
        
        $authenticated = false;
        
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;
            
            // Перевірка чи є символ : у рядку
            if (strpos($line, ':') === false) continue;
            
            // Формат у файлі: login:password
            $parts = explode(':', $line, 2);
            if (count($parts) !== 2) continue;
            
            list($correctLogin, $correctPassword) = $parts;
            
            if ($login === $correctLogin && $password === $correctPassword) {
                $authenticated = true;
                break;
            }
        }
        
        if ($authenticated) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $login;
            $message = '<p style="color: green;">Ви залогінені!</p>';
        } else {
            $message = '<p style="color: red;">Помилка: неправильний логін або пароль!</p>';
        }
    } else {
        $message = '<p style="color: red;">Помилка: файл з даними не знайдено!</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Форма входу</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
        }
        input {
            width: 100%;
            padding: 8px;
            margin: 5px 0 15px 0;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        a {
            display: inline-block;
            margin-top: 10px;
            color: #333;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Вхід до системи</h2>
    
    <?php if ($message): ?>
        <?php echo $message; ?>
    <?php endif; ?>
    
    <?php if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']): ?>
        <form method="POST" action="">
            <label>Логін:</label>
            <input type="text" name="login" required>
            
            <label>Пароль:</label>
            <input type="password" name="password" required>
            
            <button type="submit">Увійти</button>
        </form>
    <?php else: ?>
        <p>Ласкаво просимо, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!</p>
        <a href="?logout=1">Вийти</a>
    <?php endif; ?>
    
    <hr>
    <p style="font-size: 12px; color: #666;">Тестові дані: admin / 12345</p>
</body>
</html>