<?php

function logActivity($pdo, $user_id, $email, $action, $status = 'success')
{
    try {

        // Get client's IP address
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR']
            ?? $_SERVER['REMOTE_ADDR']
            ?? 'unknown';

        // If multiple IPs exist, get the first one
        if (strpos($ip, ',') !== false) {
            $ip = trim(explode(',', $ip)[0]);
        }

        // Get user agent (browser)
        $user_agent = substr(
            $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            0,
            255
        );

        // Insert activity log
        $stmt = $pdo->prepare(
            "INSERT INTO activity_logs (
                user_id,
                email,
                action,
                status,
                ip_address,
                user_agent
            ) VALUES (?, ?, ?, ?, ?, ?)"
        );

        // Execute query
        $stmt->execute([
            $user_id,
            $email,
            $action,
            $status,
            $ip,
            $user_agent
        ]);

        return true;

    } catch (PDOException $e) {
        error_log("Activity log error: " . $e->getMessage());
        return false;
    }
}
?>