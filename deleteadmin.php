<?php
session_start();
if (!isset($_SESSION['adminn'])) {
   header("Location: adminlogin.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectgu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['delete_btn'])) {
    $id_to_delete = $_POST['id'];
    
    $delete_query = "DELETE FROM users WHERE id = $id_to_delete";
    if ($conn->query($delete_query) === TRUE) {
        header("Location: admin.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>