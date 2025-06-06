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

$output = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message_content'])) {
    $message_content = $_POST['message_content'];
    $full_name = $_SESSION['full_name'];
    $full_name1 = $_SESSION['full_name1'];
    
    $insert_sql = "INSERT INTO chat (full_name, full_name1, chat) VALUES ('$full_name', '$full_name1', '$message_content')";
    if ($conn->query($insert_sql) === TRUE) {
        // Message inserted successfully
    } else {
        echo "Error: " . $insert_sql . "<br>" . $conn->error;
    }
}

// Fetch messages from the chat table
$sql = "SELECT * FROM chat WHERE (full_name = '{$_SESSION['full_name']}' AND full_name1 = '{$_SESSION['full_name1']}') OR (full_name = '{$_SESSION['full_name1']}' AND full_name1 = '{$_SESSION['full_name']}') ORDER BY id ASC";
$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $message_sender = $row['full_name'];
            $message_content = $row['chat'];
            
            if ($message_sender === $_SESSION['full_name']) {
                $output .= '<div class="message" style="color: blue;">You: ' . ' &#8594; ' . $message_content . '</div>';
            } else {
                $output .= '<div class="message" style="color: black;">' . $message_sender . '  &#8594; ' . $message_content . '</div>';
            }
        }
    } else {
        $output .= '<div class="message">No messages yet</div>';
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

echo $output;

$conn->close();
?>
