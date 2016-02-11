<?php
include 'db.php';
$id = $_GET['id'];
$result = $msql->query("SELECT * FROM images WHERE id='$id'");
$result = $result->fetch_array(MYSQLI_ASSOC);
$finfo_mime = new finfo(FILEINFO_MIME);
$type = $finfo_mime->buffer($result['content']);
$type = explode(';', $type);
$type = $type[0];
header('Content-Type: ' . $type);
echo $result['content'];
?>