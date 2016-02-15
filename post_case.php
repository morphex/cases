<?php

include 'db.php';

$id = $_POST['id'];

if (!is_numeric($_POST['id'])) {
  // New entry
  $title = $msql->real_escape_string($_POST['title']);
  $content = $msql->real_escape_string($_POST['content']);
  $msql->query("INSERT into cases (title, content) VALUES ('$title', '$content')");
  echo $msql->insert_id;
} else {
  // Update entry
  $id = $msql->real_escape_string($_POST['id']);
  $title = $msql->real_escape_string($_POST['title']);
  $content = $msql->real_escape_string($_POST['content']);
  $msql->query("UPDATE cases SET title='$title', content='$content' WHERE id = '$id'");
  echo $id;
}
?>