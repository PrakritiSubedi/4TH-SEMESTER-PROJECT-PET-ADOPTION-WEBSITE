<?php
$full_name = $_SESSION['full_name'];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    date_default_timezone_set('Asia/Kathmandu');

    $targetDirectory = "uploads/";

    if (!file_exists($targetDirectory)) {
        mkdir($targetDirectory, 0777, true);
    }

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $uniqueName = uniqid() . "." . $imageFileType;
        $targetFile = $targetDirectory . $uniqueName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $full_name = $_POST["full_name"];
            $labels = $_POST["labels"];
            $uploadDate = date("Y-m-d H:i:s");

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "uploads";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "INSERT INTO upload (full_name, image_path, label1, label2, label3, label4, label5, upload_date)
                    VALUES ('$full_name', '$targetFile', '$labels[0]', '$labels[1]', '$labels[2]', '$labels[3]', '$labels[4]', '$uploadDate')";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Upload Successful!');</script>"; 
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        } else {
            echo "Sorry, there was an error uploading the image.";
        }
    }
}
?>
