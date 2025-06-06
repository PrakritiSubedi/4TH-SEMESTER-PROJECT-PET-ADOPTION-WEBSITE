<?php
session_start();
if (!isset($_SESSION['user'])) {
   header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sneha Pet Adoption</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Roboto:wght@700&display=swap" rel="stylesheet">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.9);
        z-index: 999;
        overflow-y: auto;
    }
    .form-container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -40%);
        background: #fff;
        width: 80%;
        padding: 20px;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
    }

        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        #video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            object-fit: cover;
        }
        
        .container {
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm py-3 py-lg-0 px-3 px-lg-0 mb-5">
        <a href="indexx.php" class="navbar-brand ms-lg-5">
            <h1 class="m-0 text-uppercase text-dark"><i class="bi bi-shop fs-1 text-primary me-3"></i>Sneha Pet Adoption</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="userprofile.php" class="nav-item nav-link">
                <?php
                $full_name = $_SESSION['full_name'];
                ?>
                <!-- <i class="bi bi-person-circle h2"></i> -->
                <h1 class="h4"><?php echo $full_name; ?></h1>
                </a>
                <a href="indexx.php" class="nav-item nav-link nav-contact bg-primary text-white px-5 ms-lg-5">Log out <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </nav>

    <video autoplay muted loop id="video-background">
        <source src="video (1080p).mp4" type="video/mp4">
    </video>

    <div class="container">
    <div class="col-12">
        <button id="toggleFormButton" class="btn btn-primary w-100 py-3" onclick="toggleAdoptionForm()">Give for Adoption</button>
    </div></br>
    <div class="col-12">
    <a href="feed.php" class="btn btn-primary w-100 py-3">Search for Adoption</a>
</div><br><br><br><br>
        <div class="col-12">
            <button class="btn btn-primary btn-sm w-25 py-3" type="submit" onclick="feedback()" name="feedback">Send Feedback</button>
        </div><br>


        <!-- Feedback -->

<div class="col-12">
    <button class="btn btn-primary btn-sm w-25 py-3" type="submit" name="support" onclick="support()">Support Us</button>
</div>
<div class="overlay" id="overlay1">
    <div class="form-container">
        <button class="close-button" onclick="toggleAdoptionForm()"><strong>&times;</strong></button>
        <form action="userdash.php" method="post" enctype="multipart/form-data">
            <label class="btn btn-primary w-auto py-3" for="image">Select an image:</label><br><br>
            <input type="file" name="image" id="image" accept="image/*" required onchange="previewImage(event)" style="display: none;">

            <!-- Full Name input field -->
    <label for='full_name'>Full Name:</label>
    <input type='text' name='full_name' id='full_name' class='form-control bg-light border-0 px-4' value='<?php echo $full_name; ?>' required><br>

            <?php
            $labelNames = array("Name", "Breed", "Age", "Contact", "Description");
            for ($i = 0; $i < 5; $i++) {
                $labelName = $labelNames[$i];
                echo "<label for='label{$i}'>{$labelName}:</label>";
                echo "<input type='text' name='labels[]' id='label{$i}' class='form-control bg-light border-0 px-4' required><br>";
            }
            ?>
            <input type="submit" class="btn btn-primary w-auto py-3" name="submit" value="Upload">
        </form>
    </div>
</div>
</div>

<div class="overlay" id="overlay2">
    <div class="form-container">
        <button class="close-button" onclick="feedback()"><strong>&times;</strong></button>
        <form action="userdash.php" method="post" enctype="multipart/form-data"><br>
            
            <label for='fullname'>Full Name</label>
            <input type='text' name='fullname' id='fullname' class='form-control bg-light border-0 px-4' required><br>
            
            <label for='occupation'>Occupation</label>
            <input type='text' name='occupation' id='occupation' class='form-control bg-light border-0 px-4' required><br>
            
            <label for='label3'>Feedback</label>
            <input type='textbox' name='feedback' id='feedback' class='form-control bg-light border-0 px-4' required><br>
            
            <input type="submit" class="btn btn-primary w-auto py-3" id="alertalert" name="submit" value="Upload">
        </form>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectgu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $occupation = $conn->real_escape_string($_POST['occupation']);
    $user_feedback = $conn->real_escape_string($_POST['feedback']);

    $sql = "INSERT INTO support (fullname, occupation, feedback) VALUES ('$fullname', '$occupation', '$user_feedback')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>
    </div>
</div>

<!-- Payment -->

<div class="overlay" id="overlay3">
    <div class="form-container">
        <button class="close-button" onclick="support()"><strong>&times;</strong></button>
        <form action="userdash.php" method="post" enctype="multipart/form-data"><br>
        <img src="./img/eSewa_My_QR_9846910986_1701498905121-7316806.png" alt="QR Code" width="1050" height="500">
        </form>
    </div>
</div>


    <script>
        function toggleAdoptionForm() {
            const overlay = document.getElementById('overlay1');
            overlay.style.display = overlay.style.display === 'block' ? 'none' : 'block';
        }

        function feedback() {
            const overlay = document.getElementById('overlay2');
            overlay.style.display = overlay.style.display === 'block' ? 'none' : 'block';
        }

        function support() {
            const overlay = document.getElementById('overlay3');
            overlay.style.display = overlay.style.display === 'block' ? 'none' : 'block';
        }

        function previewImage(event) {
            const input = event.target;
            const files = input.files;
            
            for (let i = 0; i < files.length; i++) {
                const imagePreview = document.getElementById(`image-preview`);
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                };

                reader.readAsDataURL(file);
            }
        }
    </script>  

<?php
require_once "upload.php";

$uploadMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    date_default_timezone_set('Asia/Kathmandu');

    $targetDirectory = "uploads/";

    if (!file_exists($targetDirectory)) {
        mkdir($targetDirectory, 0777, true);
    }

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $tempFile = $_FILES["image"]["tmp_name"];

        if (!empty($tempFile) && is_uploaded_file($tempFile)) {
            $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
            $detectedType = exif_imagetype($tempFile);

            if (!in_array($detectedType, $allowedTypes)) {
                $uploadMessage = "The uploaded file is not an image.";
            } else {
                $imageInfo = getimagesize($tempFile);
                $uniqueName = uniqid() . "." . pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                $targetFile = $targetDirectory . $uniqueName;

                if (move_uploaded_file($tempFile, $targetFile)) {
                    $uploadDate = date("Y-m-d H:i:s");

                    $uploadMessage .= "Image has been uploaded successfully with labels and date/time:<br>";
                    for ($i = 1; $i <= 5; $i++) {
                        $label = $_POST["labels"][$i - 1];
                        $uploadMessage .= "Label {$i}: $label<br>";
                    }

                    $uploadMessage .= "Upload Date: $uploadDate<br>";
                    $uploadMessage .= '<img src="' . $targetFile . '" alt="Uploaded Image" width="150" height="200">';
                } 
            }
        } 
    } 
}
?>

</body>
<a href="#" class="btn btn-primary py-3 fs-4 back-to-top"><i class="bi bi-arrow-up"></i></a>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="js/main.js"></script>
</html>