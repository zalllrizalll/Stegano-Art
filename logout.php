<?php
session_start();

session_destroy();
echo "<script>alert('Logout success!')</script>";
header("Location: ./index.php");
exit;
