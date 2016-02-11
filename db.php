<?php
$servername = "localhost";
$username = "tester";
$password = "retset";

$msql = new mysqli($servername, $username, $password);
$msql->query("USE cases");
?>
