<?php
session_start();
require_once __DIR__ . "/../config.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = trim($_POST["password"] ?? "");

    if ($username === ADMIN_USERNAME && $password === ADMIN_PASSWORD) {
        $_SESSION["admin_logged_in"] = true;
        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Registration System</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="login-wrap">
        <h1>Login Admin</h1>
        <?php if ($error): ?>
            <p class="login-error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST" class="form">
            <div class="form-row">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required autofocus>
            </div>
            <div class="form-row">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn-submit">Masuk</button>
        </form>
    </div>
</body>
</html>