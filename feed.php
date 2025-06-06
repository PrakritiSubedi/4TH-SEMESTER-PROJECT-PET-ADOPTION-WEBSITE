<?php
session_start();
if (!isset($_SESSION['user'])) {
   header("Location: login.php");
    exit();
}

if(isset($_SESSION["full_name"])) {
   $fullName = $_SESSION["full_name"];
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>feed</title>
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
    border: 1px solid #ccc;
    margin: 0px;
    padding: 15px;
    box-shadow: 2px 2px 6px 0px rgba(0,0,0,0.20);
 }
 .img {
    width: 450px;
    height: 300px;
    float: left;
    margin-right: 15px;
 }
 .buttons {
    float: 0px;
 }
 .clearfix::after {
    content: "";
    clear: both;
    display: table;
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
                <a href="feed.php" class="nav-item nav-link">
                <?php
                $full_name = $_SESSION['full_name'];
                ?>
                <h1 class="h4"><?php echo $full_name; ?></h1>
                </a>
                <a href="indexx.php" class="nav-item nav-link nav-contact bg-primary text-white px-5 ms-lg-5">Log out <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </nav>
<?php
 $conn = new mysqli('localhost', 'root', '', 'uploads');

 if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
 }

 $full_name = $_SESSION['full_name'];
 $_SESSION['full_name1'] = $full_name;

 $sql = "SELECT * FROM upload WHERE full_name <> '$full_name' ORDER BY RAND()";
 $result = $conn->query($sql);

 if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
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
          <div class='col-12'>
              <form action='process_adoption.php' method='post'>
                  <input type='hidden' name='image_path' value='<?php echo $row['image_path']; ?>'>
                  <input type='hidden' name='full_name1' value='<?php echo $_SESSION['full_name1']; ?>'>   Picked for Adoption
                  <input type='hidden' name='full_name' value='<?php echo $row['full_name']; ?>'>   Gave for adoption  
                  <input type='hidden' name='id' value='<?php echo $row['id']; ?>'>
                  <input type='hidden' name='label1' value='<?php echo $row['label1']; ?>'>
                  <input type='hidden' name='label2' value='<?php echo $row['label2']; ?>'>
                  <input type='hidden' name='label3' value='<?php echo $row['label3']; ?>'>
                  <input type='hidden' name='label4' value='<?php echo $row['label4']; ?>'>
                  <input type='hidden' name='label5' value='<?php echo $row['label5']; ?>'>
                  <input type='hidden' name='upload_date' value='<?php echo $row['upload_date']; ?>'>
                  <button class='btn btn-primary btn-sm w-25 py-3' type='submit' name='confirmadoption'>Adopt</button>
              </form>
          </div>
      </div>
  </div>
  <?php
}
} else {
echo "No results found";
}

$conn->close();
?>
</div>

<script>
    function setDateTime() {
        var dateTimeInput = document.getElementById('date_time');
        dateTimeInput.value = new Date().toISOString();
    }

    function saveToDatabase() {
        setDateTime();

        var data = {
            name: document.getElementById('full_name').value,
            email: document.getElementById('id').value,
            date_time: document.getElementById('date_time').value
        };

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'process_adoption.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    alert('Data saved successfully!');
} else {
                    alert('Error saving data.');
                        }
    }
        };
        xhr.send(JSON.stringify(data));
    }

    $(document).ready(function() {
        $('#adoptButton').click(function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: 'process_adoption.php',
                data: $('#adoptionForm').serialize(),
                success: function(response) {
                    alert('Adoption confirmed!');
                },
                error: function(xhr, status, error) {
                    alert('Error: ' + error);
                }
            });
        });
    });
</script>

<a href="#" class="btn btn-primary py-3 fs-4 back-to-top"><i class="bi bi-arrow-up"></i></a>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>