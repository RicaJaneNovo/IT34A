<?php

function redirect($path)
{
    // Make sure the path starts with /
    if ($path === '' || $path[0] !== '/') {
        $path = '/' . $path;
    }

    header('Location: ' . BASE_URL . $path);
    exit;
}

?>