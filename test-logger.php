<?php

require_once __DIR__ . '/config/config.php';

// Test user information
$user_id = null;
$user_email = 'test@example.com';

// Test activity
$success = logActivity(
    $pdo,
    $user_id,
    $user_email,
    'test_activity',
    'success'
);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Activity Logger Test</title>
</head>

<body>

    <?php if ($success): ?>

        <h1>Success!</h1>
        <p>Activity log inserted successfully.</p>

    <?php else: ?>

        <h1>Failed!</h1>
        <p>Failed to insert activity log.</p>

    <?php endif; ?>

</body>

</html>