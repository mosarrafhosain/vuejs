<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

// no validation. You should validate something before uploading. 
// e.g. file extension, file size, file already exists or not  etc
// file upload allowed on server with max size greater than 2MB.

$res = [];

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
  $res["message"] =  "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
  $res["uploadedUrl"] = $target_file;
} else {
  $res["message"] =  "Sorry, there was an error uploading your file.";
}

echo json_encode($res);
die();
