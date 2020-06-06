<?php
require_once '../../index.php';


$id = $_GET['id'];
echo $id;

$db->Delete($id);