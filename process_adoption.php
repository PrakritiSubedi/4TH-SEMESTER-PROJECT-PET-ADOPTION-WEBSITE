<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST["full_name"]) &&
        isset($_POST["id"]) &&
        isset($_POST["full_name1"]) &&
        isset($_POST["image_path"]) &&
        isset($_POST["label1"]) &&
        isset($_POST["label2"]) &&
        isset($_POST["label3"]) &&
        isset($_POST["label4"]) &&
        isset($_POST["label5"]) &&
        isset($_POST["upload_date"])
    ) {
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectgu";

$conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

            $fullName = $_POST['full_name'];
    $fullName1 = $_POST['full_name1'];
    $imagePath = $_POST['image_path'];
        $petId = $_POST["id"];
        $label1 = $_POST["label1"];
        $label2 = $_POST["label2"];
        $label3 = $_POST["label3"];
        $label4 = $_POST["label4"];
        $label5 = $_POST["label5"];
        $upload_date = $_POST["upload_date"];

        date_default_timezone_set('Asia/Kathmandu');
        $currentDateTime = date("Y-m-d H:i:s");

        $sql = "INSERT INTO adopt (image_path, full_name, full_name1, label1, label2, label3, label4, label5, upload_date, id, date_time) VALUES ('$imagePath', '$fullName', '$fullName1', '$label1', '$label2', '$label3', '$label4', '$label5', '$upload_date', '$petId', '$currentDateTime')";

        if ($conn->query($sql) === TRUE) {
            header("Location: feed.php");
    exit();
        } else {
            echo "Error: This pet is not available at the moment. Redirecting to feed.php shortly...";
            echo '<script>
                    setTimeout(function(){
                        window.location.href = "feed.php";
                    }, 2500);
                  </script>';
        }

        $conn->close();
    } else {
        echo "Required data not set in the POST request";
    }
} else {
    echo "Invalid request method";
}
?>
