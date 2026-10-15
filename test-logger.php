<?php

// Load configuration and database connection
require_once __DIR__ . '/config/config.php';

// Test activity logger
$result = logActivity(
    $pdo,
    null,
    'test@example.com',
    'TEST_ACTIVITY',
    'success'
);

// Show result
if ($result) {

    echo "<h2>Activity log inserted successfully!</h2>";

} else {

    echo "<h2>Activity log failed to insert.</h2>";

}

?>