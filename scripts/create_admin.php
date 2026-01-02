<?php
$host = '127.0.0.1';
$port = 3306;
$user = 'root';
$pass = '';
$db = 'inventory_system';
$name = 'Admin';
$email = 'admin.login@example.com';
$password = 'Secret123!';
try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo "User with email $email already exists.\n";
        exit(0);
    }
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $now = date('Y-m-d H:i:s');
    $insert = $pdo->prepare('INSERT INTO users (`name`,`email`,`password`,`role`,`created_at`,`updated_at`) VALUES (?,?,?,?,?,?)');
    $insert->execute([$name, $email, $hash, 'admin', $now, $now]);
    echo "Admin created: $email (password: $password)\n";
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
