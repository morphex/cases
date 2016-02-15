<?php

if (empty($_FILES)) {
  return;
}

include 'db.php';

$file = fopen($_FILES['image']['tmp_name'], 'rb');
$filename = $msql->real_escape_string($_FILES['image']['name']);
$image = $msql->real_escape_string(fread($file, 1024*1024*50));
$id = $msql->real_escape_string($_POST['id']);

sleep(45);

$msql->query("START TRANSACTION");
$msql->query("DELETE FROM images where ID = '$id'");
$msql->query("INSERT INTO images (id, name, content) VALUES ('$id', '$filename', '$image')");
$msql->query("COMMIT");

echo 1;

ob_start();
var_dump($_POST);
var_dump($_FILES);
$output = ob_get_clean();
$fileHandle = fopen("/tmp/output", "w");
fwrite($fileHandle, $output);
fclose($fileHandle);

?>
