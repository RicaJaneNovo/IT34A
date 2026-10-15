
<?php

session_start();

require_once __DIR__ . '/../../config/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {

        $error = 'Please enter your username and password.';

    } else {

        $stmt = $pdo->prepare("
            SELECT user_id, user_username, user_password, user_role
            FROM users
            WHERE user_username = ?
            LIMIT 1
        ");

        $stmt->execute([$username]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['user_password'])) {

            if ($user['user_role'] === 'admin') {

                session_regenerate_id(true);

                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_username'] = $user['user_username'];
                $_SESSION['user_role'] = $user['user_role'];

                header('Location: ../admin/index.php');
                exit;

            } else {

                $error = 'This account is not an admin account.';
            }

        } else {

            $error = 'Invalid username or password.';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login</title>
</head>

<body>

    <h1>Sign In</h1>

    <?php if ($error !== ''): ?>

        <p style="color: red;">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </p>

    <?php endif; ?>

    <form method="POST">

        <label for="username">Username:</label>
        <br>

        <input
            type="text"
            id="username"
            name="username"
            required
        >

        <br><br>

        <label for="password">Password:</label>
        <br>

        <input
            type="password"
            id="password"
            name="password"
            required
        >

        <br><br>

        <button type="submit">
            SIGN IN
        </button>

    </form>

</body>

</html>
