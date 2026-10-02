<?php
session_start();
$_SESSION=[];
session_destroy();
header('Location: /hit-connect/index.php');
exit;
?>