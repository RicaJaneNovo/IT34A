/* =========================================================
   TABLE #3: Users
   ========================================================= */

CREATE TABLE IF NOT EXISTS users (

    -- Primary key
    user_id INT AUTO_INCREMENT PRIMARY KEY,

    -- User details
    user_email VARCHAR(50) UNIQUE NOT NULL,
    user_username VARCHAR(20) UNIQUE NOT NULL,
    user_password VARCHAR(255) NOT NULL,

    -- User role
    user_role ENUM('admin', 'manager', 'user')
        NOT NULL DEFAULT 'user',

    -- User created timestamp
    user_created_at TIMESTAMP
        DEFAULT CURRENT_TIMESTAMP,

    -- User updated timestamp
    user_updated_at TIMESTAMP
        DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP

);