
<?php
require_once __DIR__ . '/config/config.php';

$newPassword = 'Admin123!';
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("
    UPDATE users
    SET user_password = ?
    WHERE user_username = ?
      AND user_role = 'admin'
");

$stmt->execute([$hashedPassword, 'admin']);

echo $stmt->rowCount() > 0
    ? 'Admin password reset successfully.'
    : 'No admin account was updated. Check the username and database.';
?>
