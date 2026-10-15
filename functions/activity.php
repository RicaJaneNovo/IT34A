<?php

function logActivity(
    $pdo,
    $user_id = null,
    $user_email = null,
    $action = '',
    $status = 'success'
) {

    try {

        // Make sure an action was provided
        if (empty($action)) {
            error_log("Activity Log Error: Activity action is empty.");
            return false;
        }

        // Only allow success or failure
        if ($status !== 'success' && $status !== 'failure') {
            $status = 'failure';
        }

        // Get user's IP address
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR']
            ?? $_SERVER['REMOTE_ADDR']
            ?? null;

        // If multiple IPs exist, use the first one
        if ($ip !== null && strpos($ip, ',') !== false) {
            $ip = trim(explode(',', $ip)[0]);
        }

        // activity_log_ip_address is VARCHAR(45)
        if ($ip !== null) {
            $ip = substr(trim($ip), 0, 45);
        }

        // Get browser/user-agent
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? null;

        // activity_log_user_agent is VARCHAR(255)
        if ($user_agent !== null) {
            $user_agent = substr($user_agent, 0, 255);
        }

        // user_id is INT(11)
        if ($user_id === '' || $user_id === null) {
            $user_id = null;
        } else {
            $user_id = (int) $user_id;
        }

        // user_email can be NULL
        if ($user_email === '') {
            $user_email = null;
        }

        // Insert activity log
        $sql = "
            INSERT INTO activity_logs (
                user_id,
                user_email,
                activity_log_action,
                activity_log_status,
                activity_log_ip_address,
                activity_log_user_agent
            )
            VALUES (
                :user_id,
                :user_email,
                :action,
                :status,
                :ip,
                :user_agent
            )
        ";

        $stmt = $pdo->prepare($sql);

        // User ID
        $stmt->bindValue(
            ':user_id',
            $user_id,
            $user_id === null
                ? PDO::PARAM_NULL
                : PDO::PARAM_INT
        );

        // Email
        $stmt->bindValue(
            ':user_email',
            $user_email,
            $user_email === null
                ? PDO::PARAM_NULL
                : PDO::PARAM_STR
        );

        // Action
        $stmt->bindValue(
            ':action',
            $action,
            PDO::PARAM_STR
        );

        // Status
        $stmt->bindValue(
            ':status',
            $status,
            PDO::PARAM_STR
        );

        // IP address
        $stmt->bindValue(
            ':ip',
            $ip,
            $ip === null
                ? PDO::PARAM_NULL
                : PDO::PARAM_STR
        );

        // User agent
        $stmt->bindValue(
            ':user_agent',
            $user_agent,
            $user_agent === null
                ? PDO::PARAM_NULL
                : PDO::PARAM_STR
        );

        // Execute INSERT
        return $stmt->execute();

    } catch (PDOException $e) {

        // Save error in PHP error log
        error_log(
            "Activity Log Error: " . $e->getMessage()
        );

        return false;
    }
}

?>