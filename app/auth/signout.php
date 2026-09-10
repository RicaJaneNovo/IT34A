<?php

session_start();

$_SESSION = [];

session_destroy();

header('Location: ../../test/index.php');
exit;

?>