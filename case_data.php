<?php header('Content-Type: text/xml;charset=utf-8') ?>
<?php echo '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>'; ?>
<?php

include 'db.php';

$id = $msql->real_escape_string($_GET['id']);
$result = $msql->query("SELECT * FROM cases WHERE id='$id'");
$row = $result->fetch_array(MYSQLI_ASSOC);
// echo var_dump($row);
$title = $row['title'];
$content = $row['content'];
$result = $msql->query("SELECT * FROM images WHERE id='$id'");
if ($result) {
  $has_image = $result->num_rows;
} else {
  $has_image = 0;
}

?>

<case>
	<title><?php echo htmlentities($title); ?></title>
 	<content><?php echo nl2br(htmlentities($content)); ?></content>
	<has_image><?php echo $has_image ?></has_image>
</case>
