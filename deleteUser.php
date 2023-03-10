<?php

include 'database.php';

$db= new DatabaseClass();

if(isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    $db->deleteUser($id);
}
header("Location: readUser.php");
exit;
?>