<?php

include 'db.php';

if (empty($_POST['id'])) {
  // New entry
  $title = $msql->real_escape_string($_POST['title']);
  $content = $msql->real_escape_string($_POST['content']);
  $msql->query("INSERT into cases (title, content) VALUES ('$title', '$content')");
echo $msql->insert_id;
} else {
  trigger_error($_POST['id']);
}
?>