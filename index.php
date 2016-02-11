<?php echo '<?xml version"1.0" encoding="UTF-8"?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="no" lang="no">
<?php

include 'db.php';

?>

<head>
	<meta charset="utf-8" /> 
	<title>Test</title>
	<script type="text/javascript" src="jquery-1.12.0.min.js"></script>
	<script type="text/javascript">
// Global variable for working on the ID
var id = "";

function increment_counter() {
  var counter = $("#counter");
  counter.text(parseInt(counter.text()) + 1);
}

function decrement_counter() {
  var counter = $("#counter");
  counter.text(parseInt(counter.text()) - 1);
}

function save_case() {
var case_form = $("#case_form");
id = $.ajax({type:'POST',
  url:'post_case.php',
  data:case_form.serialize(),
  async:false,
}).responseText;
$("#id").val(id);
increment_counter();

form_data = new FormData();
form_data.append("image", $("#image").prop('files')[0])
form_data.append("id", $("#id").val())
$.ajax({type:'POST',
  url:'post_image.php',
  data:form_data,
  success:decrement_counter,
  cache:false,
  contentType:false,
  processData:false
})
$("#case_edit").css('display', 'none');
$("#case_form")[0].reset();
$("#content").html(content); // Necessary to reset textarea
}

function setup_view(id) {
var title = "";
var content = "";
var has_image = "0";
data = $.ajax({type:'GET',
  url:'case_data.php',
  data:{'id':id},
  cache:false,
  dataType:'xml',
  async:false,
  success:function(xml){
    xml = $(xml);
    title = xml.find('title').first().text();
    content = xml.find('content').first().text();
    has_image = xml.find('has_image').first().text();
  }
})
$("#title_view").text(title);
$("#content_view").text(content);
if (parseInt(has_image) > 0) {
  $("#image_view").attr('src', 'view_image.php?id='+id);
  $("#image_coming").css('display', 'none');
} else {
  $("#image_coming").css('display', 'inline');  
}
$("#edit_case_button").attr('onclick', "edit_case("+id+")")
$("#case_view").css('display', 'block');
$("#case_edit").css('display', 'none');
}

function new_case() {
  $("#case_form")[0].reset();
  $("#content").html(content); // Necessary to reset textarea
  $('#case_edit').css('display', 'block');
  $('#case_view').css('display', 'none');
}

function edit_case(id) {
var title = "";
var content = "";
var has_image = "0";
data = $.ajax({type:'GET',
  url:'case_data.php',
  data:{'id':id},
  cache:false,
  dataType:'xml',
  async:false,
  success:function(xml){
    xml = $(xml);
    title = xml.find('title').first().text();
    content = xml.find('content').first().text();
    has_image = xml.find('has_image').first().text();
  }
})
$("#id").val(id);
$("#title").val(title);
$("#content").html(content);
$("#case_view").css('display', 'none');
$("#case_edit").css('display', 'block');
}
</script>
</head>
<body>
<div id="wrapper" style="width: 600px">
<div id="nav" style="float: left; width: 200px;">

<?php

$result = $msql->query("SELECT * FROM cases");
while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
$id = $row['id'];
$title = $row['title'];
echo "<a href=\"#\" onclick='javascript:";
echo "setup_view(";
echo $id;
echo ");'>Se p&aring; {$title}</a>";
echo '<br />';
}

?>

<br /><br />
<a href="#" onclick="new_case()">Ny sak</a><br /><br />

<span id="counter">0</span> bilder lastes opp.
</div>
<div id="main" style="float: right; width: 400px;">

<div id="case_view" style="display: block;">
<h1 id="title_view"></h1>
<img id="image_view" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAZAAAAGQCAYAAACAvzbMAAAACXBIWXMAAAsTAAALEwEAmpwYAAADWUlEQVR42u3c0WqDMBSA4Wj2/m9ssptsnIWkXsx1aL4PAhZpC978nGqTEgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAFxne8NnVpcZ4Hk+/iAcsygJCYCATMOxTSaQKiQAAtLHY7ZiPGoXEhEBMIF8B2MPKwakhCUeAA+RLwxHbkHKbfUxAcAEMoxIDitOIEc4ru2cKQRg0YD09zviFPJ1nNLPn6329rq/RwLAghPIq5ikEInZE1oA3NTuEgDwXxNI/5huCedKGj/GC8DN5V++f/Tfj60LxtFCcgyCAsCCAZltXRInkTKJBwCLTyB9QOogIEc4Nn0APMRV90BSCERJ51uZAHBz24WfcbaZon2wAATkNCSjCUU4AB4kv+E7hAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAYHmfSllSNVhSZsoAAAAASUVORK5CYII=" />
<span id="image_coming" style="display: none;">Bilder er ikke lastet opp enn&aring;</span>
<div id="content_view"></div>
<form>
<input type="button" id="edit_case_button" value=" Rediger denne saken " onclick="edit_case()" />
</form>
</div>

<div id="case_edit" style="display: none;">
<form name="case_form" id="case_form">
<input type="hidden" name="id" id="id" value="" />
<script type="text/javascript">
</script>
<input type="text" name="title" id="title" size="50" /><br /><br />
<input type="file" name="image" id="image" size="40" /><br /><br />
<textarea name="content" id="content"
	  rows="10" cols="72"></textarea><br /><br />
<input type="button" onclick="save_case()" value=" Lagre " />
</form>
</div>

</div>
</div>
<script type="text/javascript">
var default_image = $("#image_view").attr('src');
</script>
</body>
</html>
