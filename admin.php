<?php
session_start();
if (!isset($_SESSION['adminn'])) {
   header("Location: adminlogin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sneha Pet Adoption</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Roboto:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
 .card {
    width: 100%;
    border: 3px solid #ccc;
    margin: 0px;
    padding: 30px;
    box-shadow: 2px 2px 6px 0px rgba(0,0,0,0.20);
 }
 .clearfix::after {
    content: "";
    clear: both;
    display: table;
 }

 .small-text {
    font-size: 20px;
}
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
        position: relative;
        top: 10%;
        left: 50%;
        transform: translate(-50%, 0%);
        background: #fff;
        width: 80%;
        padding: 20px;
        max-height: 80%;
        overflow-y: auto;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
    }
    
    .close-button {
    position: fixed;
    top: 10px;
    right: 10px;
    z-index: 1;
    background: red;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
}
.card1 {
    width: 100%;
    border: 1px solid #ccc;
    padding: 15px;
    box-shadow: 2px 2px 6px 0px rgba(0,0,0,0.20);
 }
 .img {
    width: 250px;
    height: 180px;
    margin-right: 20px;
 }
 .buttons {
    display: flex;
  justify-content: flex-end;
  align-items: flex-end;
 }

 .buttons button {
  padding: 5px 10px;
  background-color: #333;
  color: white;
  border: none;
  cursor: pointer;
  float: right;
}

 .clearfix {
  display: flex;
}
 .clearfix::after {
    content: "";
    clear: both;
    display: table;
 }

 .card1 .text h5{
  font-family: 'Poppins', sans-serif;
  font-size: 15px;
 }

 .card1 div h5{
  font-family: 'Poppins', sans-serif;
  font-size: 15px;
 }

 .card div h3{
  font-family: 'Poppins', sans-serif;
  font-size: 15px;
 }
</style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm py-3 py-lg-0 px-3 px-lg-0">
        <a href="indexx.php" class="navbar-brand ms-lg-5">
            <h1 class="m-0 text-uppercase text-dark"><i class="bi bi-shop fs-1 text-primary me-3"></i>Sneha Pet Adoption</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="logout.php" class="nav-item nav-link nav-contact bg-primary text-white px-5 ms-lg-5">Log out <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </nav>

    <div class="container"><br><br>
    <div class="col-12">
        <button class="btn btn-primary w-100 py-3" name="registeredusers" onclick="registeredusers()">Show Registered Users</button>
    </div><br>
    <div class="col-12">
        <button class="btn btn-primary w-100 py-3" name="petsadoption" onclick="petsadoption()">Show Pets for Adoption</button>
    </div><br>
    <div class="col-12">
        <button class="btn btn-primary w-100 py-3" name="adoptions" onclick="adoptions()">Show done Adoptions</button>
    </div>
    </div>

    <!-- Show Registered Users -->

    <div class="overlay" id="overlay1">
    <div class="form-container">
        <button class="close-button" onclick="registeredusers()"><strong>&times;</strong></button><br>
        
<?php
$conn = new mysqli('localhost', 'root', '', 'projectgu');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "
        <div class='card'>
            <div class='clearfix'>
                <div>
                    <h3>ID: " . $row['id'] . "</h3>
                    <h3><span class='small-text'>Email: " . $row['email'] . "</span></h3>
                    <h3><span class='small-text'>Name: " . $row['full_name'] . "</span></h3>
                    <form method='post' action='deleteadmin.php'>
                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                        <button type='submit' name='delete_btn'>Delete</button>
                    </form>
                </div>
            </div>
        </div>
      ";
    }
} else {
    echo "No results found";
}
$conn->close();
?>
    </div>
</div>

       <!-- Show Pets for Adoption -->

    <div class="overlay" id="overlay2">
    <div class="form-container">
        <button class="close-button" onclick="petsadoption()"><strong>&times;</strong></button><br>
    <?php
 $conn = new mysqli('localhost', 'root', '', 'uploads');

 if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
 }

 $sql = "SELECT * FROM upload ORDER BY RAND()";
 $result = $conn->query($sql);

 if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo "
        <div class='card1'>
          <div class='clearfix'>
            <img class='img' src='" . $row['image_path'] . "' alt='Image'>
            <div>
              <h5 class='border-0 px-4'>Uploaded by: " . $row['full_name'] . "</h5>
              <h5 class='border-0 px-4'>Name: " . $row['label1'] . "</h5>
              <h5 class='border-0 px-4'>Breed: " . $row['label2'] . "</h5>
              <h5 class='border-0 px-4'>Age: " . $row['label3'] . "</h5>
              <h5 class='border-0 px-4'>Contact: " . $row['label4'] . "</h5>
              <h5 class='border-0 px-4'>Description: " . $row['label5'] . "</h5>
              <h5 class='border-0 px-4'>" . $row['upload_date'] . "</h5>
            </div>
          </div>
        </div>
      ";
    }
 } else {
    echo "No results found";
 }
 $conn->close();
?>
    </div>
       </div>

      <!-- adoptions in admin.php -->

       <div class="overlay" id="overlay3">
    <div class="form-container">
        <button class="close-button" onclick="adoptions()"><strong>&times;</strong></button><br>
<?php
 $conn = new mysqli('localhost', 'root', '', 'projectgu');

 if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
 }

 $sql = "SELECT * FROM pet_adoptions";
 $result = $conn->query($sql);

 if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo "
        <div class='card1'>
          <div class='clearfix'>
            <img class='img' src='" . $row['image_path'] . "' alt='Image'>
            <div class='text'>
              <h6 class='border-0 px-4'>" . $row['full_name1'] . " adopted pet " . $row['id'] . " . The pet was given for adoption by " . $row['full_name'] . "</h6>
              <h5 class='border-0 px-4'>Name: " . $row['label_1'] . "</h5>
              <h5 class='border-0 px-4'>Breed: " . $row['label_2'] . "</h5>
              <h5 class='border-0 px-4'>Age: " . $row['label_3'] . "</h5>
              <h5 class='border-0 px-4'>Contact: " . $row['label_4'] . "</h5>
              <h5 class='border-0 px-4'>Description: " . $row['label_5'] . "</h5>
              <h5 class='border-0 px-4'>Adoption uploaded time: " . $row['upload_date'] . "</h5>
              <h5 class='border-0 px-4'>Adoption picked time: " . $row['date_time'] . "</h5>
              <h5 class='border-0 px-4'>Adoption done time: " . $row['last_time'] . "</h5>
              </div>
          </div>
        </div>
      ";
    }
 } else {
    echo "No results found";
 }
 $conn->close();
?>
    </div>
       </div>
       
<!-- Delete PHP -->

<?php

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
    
    $delete_query = "DELETE FROM adopt WHERE id = $id_to_delete";
    if ($conn->query($delete_query) === TRUE) {
        echo "";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>
       

<script>
    function registeredusers() {
            const overlay = document.getElementById('overlay1');
            overlay.style.display = overlay.style.display === 'block' ? 'none' : 'block';
        }

    function petsadoption() {
        const overlay = document.getElementById('overlay2');
        overlay.style.display = overlay.style.display === 'block' ? 'none' : 'block';
    }

    function adoptions() {
        const overlay = document.getElementById('overlay3');
        overlay.style.display = overlay.style.display === 'block' ? 'none' : 'block';
    }
    </script>


<a href="#" class="btn btn-primary py-3 fs-4 back-to-top"><i class="bi bi-arrow-up"></i></a>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
