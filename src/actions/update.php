<?php
//require_once '../../index.php';

$id = $_GET['id'];
$cat = $db->fetchCat($id);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zadatak 1</title>
</head>

<body>
    <span>EDIT FIGHTER</span>
    <form method="POST" action="upload.php" enctype="multipart/form-data">
        <div>
            <label style="width:100px">Name</label>
            <input type="text" id="addName" name="addName" required value="test">
        </div>
        <label style="width:100px">Age</label>
        <input type="number" id="addAge" name="addAge" required>
        <div>
            <label style="width:100px">Cat info</label>
            <input type="text" id="addInfo" name="addInfo" required>
        </div>
        <label style="width:100px">Wins</label>
        <input type="number" id="addWins" name="addWins" required>
        <div>
            <label style="width:100px">Loss</label>
            <input type="number" id="addLoss" name="addLoss" required>
        </div>
        <input type="file" required id="fileToUpload" name="fileToUpload">
        <div style="margin-top: 25px;">
            <button type="submit">Add</button>
        </div>
    </form>
</body>




<?php


/*
$image = $_POST['img'];
$name = $_POST['addName'];
$age = $_POST['addAge'];
$catInfo = $_POST['addInfo'];
$catWins = $_POST['addWins'];
$catLoss = $_POST['addLoss'];

$db->Delete($id);*/
?>