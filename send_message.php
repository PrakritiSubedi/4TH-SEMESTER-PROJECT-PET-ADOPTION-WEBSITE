<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectgu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message']) && isset($_POST['id'])) {
    $message = $_POST['message'];
    $full_name = $_SESSION['full_name'];
    $full_name1 = $_SESSION['full_name1'];

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $_POST['id'];

    $sql = "INSERT INTO chat (full_name, chat, full_name1, petid) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $full_name, $message, $full_name1, $id);

    if ($stmt->execute()) {
        $stmt->close();
    } else {
        echo "Error: " . $stmt->error;
    }
}
}

$conn->close();
?>
