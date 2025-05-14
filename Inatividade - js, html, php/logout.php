<?php
session_start();
session_unset();
session_destroy();

header("Location: /backend/public/login.html");
exit();
?>
