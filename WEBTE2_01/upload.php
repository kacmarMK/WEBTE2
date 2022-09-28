
<?php
$target_dir = $_POST["path"];
$tmp_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($tmp_file,PATHINFO_EXTENSION));
$name = $_POST["nameOfFile"].$imageFileType. "_" . time().".".$fileType;
$target = $target_dir.$name;


// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  header("Location: http://wt69.fei.stuba.sk/z1mKcmrX/");
// if everything is ok, try to upload file
} else {
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target);
    header("Location: http://wt69.fei.stuba.sk/z1mKcmrX/");
}
?>
