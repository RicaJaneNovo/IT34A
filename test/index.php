<?php

session_start();

require_once __DIR__ . '/../config/config.php';

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

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['user_password'])) {

            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['user_username'];
            $_SESSION['role'] = $user['user_role'];

        if ($user['user_role'] === 'admin') {

            header('Location: ../app/admin/index.php');
                 exit;

} elseif ($user['user_role'] === 'manager') {

            header('Location: ../app/manager/index.php');
               exit;

} elseif ($user['user_role'] === 'user') {

            header('Location: ../app/user/index.php');
                exit;

}

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
            <?= htmlspecialchars($error) ?>
        </p>

    <?php endif; ?>

    <form method="POST">

    <p>
        <label for="username">Username:</label>
        <input
            type="text"
            id="username"
            name="username"
            autocomplete="off"
            required
        >
    </p>

    <p>
        <label for="password">Password:</label>
        <input
            type="password"
            id="password"
            name="password"
            required
        >
    </p>

    <button type="submit">
        SIGN IN
    </button>

</form>

</body>

</html>