<?php
require_once '../../index.php';


//$db->testGetImage();

$target_dir = $_SERVER['DOCUMENT_ROOT'];
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

echo $target_file;

if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $image_base64 = base64_encode(file_get_contents($_FILES['fileToUpload']['tmp_name']) );
    $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;
    /*if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
        $db->testInsertImage($target_file);
    } else {
        echo "Sorry, there was an error uploading your file.";
    }*/
    $db->InsertImage($image);
}

$db->testGetImage();

/*
$target_dir = "uploads/";
$target_file = $target_dir . basename();

$file_name = "src/cat1.jpeg";

$img = fopen($file_name, 'r') or die("cannot read image\n");
$data = fread($img, filesize($file_name));

$es_data = pg_escape_bytea($_FILES["fileToUpload"]);
fclose($img);

$query = "INSERT INTO cats_l(id, img, file_size) Values(2, '$es_data'," . filesize($file_name) . ")";
$this->Create($query);*/