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
                <a class="nav-item nav-link">
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
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projectgu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'])) {
    $message = $_POST['message'];
    $full_name = $_SESSION['full_name'];

    $sql = "INSERT INTO chat (full_name, chat) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $full_name, $message);

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Chat</title>
</head>
<style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .chat-container {
      max-width: 400px;
      margin: 20px auto;
      border: 1px solid #ccc;
      padding: 10px;
      border-radius: 5px;
    }

    .chat-messages {
      max-height: 300px;
      overflow-y: auto;
      border-bottom: 1px solid #ccc;
      padding-bottom: 10px;
    }

    .message {
      margin-bottom: 10px;
      padding: 5px;
      border-radius: 5px;
      background-color: #f2f2f2;
    }

    .chat-input {
      display: flex;
      margin-top: 10px;
    }

    .message-input {
      flex: 1;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 3px;
      margin-right: 5px;
    }

    .send-button {
      padding: 8px 15px;
      border: none;
      border-radius: 3px;
      background-color: #007bff;
      color: white;
      cursor: pointer;
      background-color: green;
    }

    .chat-messages {
  max-height: 300px;
  overflow-y: auto;
  border-bottom: 1px solid #ccc;
  padding-bottom: 10px;
  scroll-behavior: smooth;
}

.chat-messages-inner {
  overflow: hidden;
}

.message {
  margin-bottom: 10px;
  padding: 5px;
  border-radius: 5px;
  background-color: #f2f2f2;
  align-self: flex-end;
}

div h5{
    color: green;
}

div h5 h7{
    color: black;
    font-size: medium;
}
  </style>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<body>
<div class="chat-container">
    <h5><?php
        if ($_POST['id']) {
            echo "<h7>Chat for Pet id: {$_POST['id']}</h7><br>";
        } else {
            echo "<h7>Row ID is not set or \$row is empty.</h7>";
        }
    if (isset($_SESSION['full_name1'])) {
        $full_name1 = $_SESSION['full_name1'];
        echo $full_name1;
    }
    ?></h5>
    <div class="chat-messages" id="chatMessages">
        <!-- Chat messages -->
    </div>
    <form id="messageForm">
        <div class="chat-input">
            <input type="text" class="message-input" name="message" id="messageInput" placeholder="Write something...">
            <button type="submit" class="send-button" id="sendMessage">Send</button>
        </div>
    </form>
</div>

<script>
$(document).ready(function() {
    var id = <?php echo isset($_POST['id']) ? $_POST['id'] : 'null'; ?>;

    function loadChat() {
        $.ajax({
            url: "fetch_chat.php",
            type: "GET",
            success: function(data) {
                $('#chatMessages').html(data);
                var chatMessages = document.getElementById('chatMessages');
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        });
    }

    loadChat();

    $('#messageForm').submit(function(e) {
        e.preventDefault();
        var message = $('#messageInput').val();

        $.ajax({
            url: "send_message.php",
            type: "POST",
            data: { message: message, id: id },
            success: function() {
                $('#messageInput').val('');
                loadChat();
            }
        });
    });

    setInterval(function() {
        loadChat();
    }, 1000);
});

</script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
