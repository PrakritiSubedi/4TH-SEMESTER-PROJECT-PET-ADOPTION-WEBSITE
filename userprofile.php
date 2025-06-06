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
/* CSS for the overlay */
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
    /* CSS for the form container */
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
.card {
    width: 100%;
    border: 1px solid #ccc;
    padding: 15px;
    box-shadow: 2px 2px 6px 0px rgba(0,0,0,0.20);
 }
 .img {
    width: 250px;
    height: 180px;
    float: left;
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
  display: block;
}

.card div h4{
  font-family: 'Poppins', sans-serif;
  font-size: 15px;
 }

 .card div h5{
  font-family: 'Poppins', sans-serif;
  font-size: 15px;
 }

 .card div p{
  font-family: 'Poppins', sans-serif;
  font-size: 15px;
 }

 .card div h6{
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
        <button class="btn btn-primary w-100 py-3" name="yourposts" onclick="yourposts()">Your Posts</button>
    </div><br>
    <div class="col-12">
        <button class="btn btn-primary w-100 py-3" name="seeadoptionsrequests" onclick="seeadoptionsrequests()">See Adoptions</button>
    </div><br>
    <div class="col-12">
        <button class="btn btn-primary w-100 py-3" name="adoptions" onclick="adoptions()">Show done Adoptions</button>
    </div>
    </div>

    <!-- Show Posts -->

    <div class="overlay" id="overlay1">
    <div class="form-container">
        <button class="close-button" onclick="yourposts()"><strong>&times;</strong></button><br>
        
<?php
if (!isset($_SESSION['full_name'])) {
    echo "Full name not found in the session.";
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "uploads";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$full_name = $_SESSION['full_name'];

$sql = "SELECT * FROM upload WHERE full_name = '$full_name'";

$result = $conn->query($sql);

if ($result === false) {
    echo "Error executing the query: " . $conn->error;
} else {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
?>
            <div class='card'>
                <div class='clearfix'>
                    <img class='img' src='<?php echo $row['image_path']; ?>' alt='Image'>
                    <div>
                        <h4><?php echo $row['full_name']; ?></h4>
                        <h5>Pet Id: <?php echo $row['id']; ?></h5>
                        <h5>Name: <?php echo $row['label1']; ?></h5>
                        <h5>Breed: <?php echo $row['label2']; ?></h5>
                        <h5>Age: <?php echo $row['label3']; ?></h5>
                        <h5>Contact: <?php echo $row['label4']; ?></h5>
                        <h5>Description: <?php echo $row['label5']; ?></h5>
                        <p><strong>Upload Date:</strong> <?php echo $row['upload_date']; ?></p>
                    </div>
                </div>
            </div>
<?php
        }
    } else {
        echo "No results found for full name: " . $full_name;
    }
}

$conn->close();
?>
    </div>
</div>

       <!-- Show Pets for Adoption -->

<div class="overlay" id="overlay2">
<div class="form-container">
        <button class="close-button" onclick="seeadoptionsrequests()"><strong>&times;</strong></button><br>

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectgu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$full_name = $_SESSION['full_name'];

$sql = "SELECT * FROM adopt WHERE full_name = '$full_name'";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error executing the query: " . $conn->error;
} else {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $adopted_full_name = $row['full_name1'];
            $_SESSION['full_name1'] = $adopted_full_name;
            $_SESSION['pet_id'] = $row['id'];
            ?>
<div class='card'>
    <div class='clearfix'>
        <img class='img' src='<?php echo $row['image_path']; ?>' alt='Image'>
        <p><?php echo $adopted_full_name; ?> wants to adopt your pet.</p>
        <h5>Pet Id: <?php echo $row['id']; ?></h5>
        <p><strong>Applied Time:</strong> <?php echo $row['date_time']; ?></p>
        <form method="post" action="userprofile.php">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <button type="submit" name="delete_btn">Reject</button>
        </form><br>
        <form method="post" action="pet_adoptions.php">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <button type="submit" name="confirm_btn">Confirm</button>
        </form>
        <?php
        $_SESSION['full_name1'] = $adopted_full_name;
        ?>
        <form method="post" action="chat.php">
            <input type="hidden" name="full_name" value="<?php echo htmlspecialchars($_SESSION['full_name']); ?>">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <input type="hidden" name="full_name1" value="<?php echo isset($_SESSION['full_name1']) ? htmlspecialchars($_SESSION['full_name1']) : ''; ?>">
            <button type="submit" name="chat_btn">Chat</button>
        </form>
    </div>
</div>

            <?php
        }
    } 
}
$conn->close();
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

$full_name = $_SESSION['full_name'];

$sql = "SELECT * FROM adopt WHERE full_name1 = '$full_name'";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error executing the query: " . $conn->error;
} else {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class='card'>
                <div class='clearfix'>
                    <div>
                    <img class='img' src='<?php echo $row['image_path']; ?>' alt='Image'>
                    <p>Adoption request/s by you: </p>
                    <h5>Pet Id: <?php echo $row['id']; ?></h5>
                    <p><strong>Applied Time:</strong> <?php echo $row['date_time']; ?></p>
                    <form method="post" action="userprofile.php">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delete_btn">Delete</button>
                    </form>
                    <form method="post" action="chat.php">
                        <input type="hidden" name="full_name" value="<?php echo htmlspecialchars($_SESSION['full_name']); ?>">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="chat_btn">Chat</button>
                    </form>
                    </div>
            <?php
        }
    } 
}
$conn->close();
?>
</div>
</div> 

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
        echo '<script>
                setTimeout(function(){
                    alert("Record deleted successfully");
                }, 3000);
              </script>';
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>
</div>
       </div>


       <!-- overlay 3 -->

<div class="overlay" id="overlay3">
    <div class="form-container">
        <button class="close-button" onclick="adoptions()"><strong>&times;</strong></button><br>
        
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectgu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$full_name = $_SESSION['full_name'];

$sql = "SELECT * FROM pet_adoptions WHERE full_name = '$full_name'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo "
        <div class='card'>
          <div class='clearfix'>
            <img class='img' src='" . $row['image_path'] . "' alt='Image'>
            <div class='text'>
              <h6 class='border-0 px-4'>You adopted pet " . $row['id'] . " . The pet was given for adoption by " . $row['full_name1'] . "</h6>
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
}
$conn->close();
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
$full_name = $_SESSION['full_name'];

$sql = "SELECT * FROM pet_adoptions WHERE full_name1 = '$full_name'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo "
        <div class='card'>
          <div class='clearfix'>
            <img class='img' src='" . $row['image_path'] . "' alt='Image'>
            <div class='text'>
              <h6 class='border-0 px-4'>The pet [" . $row['id'] . "] you gave for adoption was adopted by " . $row['full_name'] . "</h6>
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
}
$conn->close();
?>


    </div>
</div>
       

<script>
    function yourposts() {
            const overlay = document.getElementById('overlay1');
            overlay.style.display = overlay.style.display === 'block' ? 'none' : 'block';
        }

    function seeadoptionsrequests() {
        const overlay = document.getElementById('overlay2');
        overlay.style.display = overlay.style.display === 'block' ? 'none' : 'block';
    }

    function adoptions() {
        const overlay = document.getElementById('overlay3');
        overlay.style.display = overlay.style.display === 'block' ? 'none' : 'block';
    }
    </script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>

</body>
</html>