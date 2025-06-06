<?php
session_start();

$conn = mysqli_connect('localhost', 'root', '', 'projectgu');

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

if (isset($_POST['confirm_btn'])) {
    if (isset($_SESSION['full_name']) && !empty($_SESSION['full_name'])) {
        $full_name = $_SESSION['full_name'];

        $sql = "SELECT * FROM adopt WHERE full_name = ?";
        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "s", $full_name);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $full_name = $row['full_name'];
                $full_name1 = $row['full_name1'];
                $label1 = $row['label1'];
                $label2 = $row['label2'];
                $label3 = $row['label3'];
                $label4 = $row['label4'];
                $label5 = $row['label5'];
                $upload_date = $row['upload_date'];
                $date_time = $row['date_time'];
                $image_path = $row['image_path'];
            }
            
            date_default_timezone_set('Asia/Kathmandu');
            $current_time = date('Y-m-d H:i:s');

            $insert_sql = "INSERT INTO pet_adoptions (id, full_name, full_name1, label_1, label_2, label_3, label_4, label_5, upload_date, date_time, image_path, last_time)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $insert_stmt = mysqli_prepare($conn, $insert_sql);

            mysqli_stmt_bind_param($insert_stmt, "isssssssssss", $id, $full_name, $full_name1, $label1, $label2, $label3, $label4, $label5, $upload_date, $date_time, $image_path, $current_time);
            
            if (mysqli_stmt_execute($insert_stmt)) {
                echo "Data uploaded successfully";
            } else {
                echo "Error uploading data: " . mysqli_error($conn);
            }

            mysqli_stmt_close($insert_stmt);
        } else {
            echo "Full name not found in the adopt table";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Full name not found in session or is empty";
    }
}

mysqli_close($conn);
?>

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectgu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['confirm_btn'])) {
    $id_to_delete = $_POST['id'];
    
    $delete_query = "DELETE FROM adopt WHERE id = $id_to_delete";
    if ($conn->query($delete_query) === TRUE) {
        echo "";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>
