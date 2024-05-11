
<?php
$servername = "localhost";
$username = "u170552379_admin";
$password = "DENTELLIGENt@2019";
$dbname = "u170552379_workdent";

// Establish the database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check for existing session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the form is submitted for changing password
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    // Get user-provided details from the form
    $userProvidedUsername = $_SESSION['username'];
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmNewPassword = $_POST['confirm_new_password'];

    // Validate the current password
    $stmt = $conn->prepare("SELECT id FROM logins WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $userProvidedUsername, $currentPassword);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Current password is correct, proceed to change password
        if ($newPassword == $confirmNewPassword) {
            // Use prepared statement to update the password
            $updateStmt = $conn->prepare("UPDATE logins SET password = ? WHERE username = ?");
            $updateStmt->bind_param("ss", $newPassword, $userProvidedUsername);
            $updateStmt->execute();

            echo "<script type='text/javascript'>alert('Password changed successfully');</script>";
        } else {
            echo "<script type='text/javascript'>alert('New passwords do not match');</script>";
        }
    } else {
        echo "<script type='text/javascript'>alert('Invalid current password');</script>";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sidebar with Icons</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    body {
      margin: 0;
      font-family: 'Arial', sans-serif;
    }
    .fa {
       font-size:25px;
    }
    #sidebar {
      height: 100%;
      width: 80px;
      position: fixed;
      background-color: #050A5C;
      overflow-x: hidden;
      transition: 0.5s;
      padding-top: 20px;
    }
    #sidebar.show {
        width: 200px;
    }
    #sidebar a {
      padding: 8px 8px 8px 32px;
      text-decoration: none;
      font-size: 18px;
      color: white;
      display: block;
      transition: 0.3s;
    }
    #sidebar a span {
      display: none; /* Initially hide the names */
    }
    #sidebar.show a span {
        display: inline-block;
    }
    #sidebar a:hover {
      color: #3ADCCE;
    }
    #main {
      margin-left: 50px;
      padding: 2px;
    }
    .icon-container {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    #nav-bg {
        background-color: #050A5C;
    }
    .bt3 {
        display: none;
    }
     .change-password-container {
            text-align: center;
            margin-top: 20px;
        }

        .change-password-form {
            max-width: 300px;
            margin: auto;
        }

        .btn-change-password {
            width: 100%;
        }
    @media (max-width: 768px) {
        #sidebar {
            width: 0;
        }
        #main {
            margin-left: 0;
        }
        #sidebar.show {
            width: 200px;
        }
        #main.shift {
            margin-left: 0px;
        }
        #sidebar.show a span {
            display: inline-block;
        }
        .bt3 {
            display: inline-block;
        }
        .change-password-form {
            max-width: 100%;
            margin: auto;
        }
    }
  </style>
</head>
<body onload="getLocation();">

<div id="sidebar" class="">
  <a href="#" onclick="toggleSidebar()" class="text-light"><i class="fa fa-bars"></i> <span>&nbsp;  MENU</span></a>
  <a href="welcome.php" class="text-light">
    <div class="icon-container">
      <i class="fa fa-home "></i>
      <span>Home</span>
    </div>
  </a>
  <a href="user_info.php" class="text-light">
        <div class="icon-container">
            <i class="fa fa-user-circle-o"></i>
            <span>
                User Details
              </span>
        </div>
    </a>
  <a href="user_form.php" class="text-light">
    <div class="icon-container">
      <i class="fa fa-edit"></i>
      <span>Add New </span>
    </div>
  </a>
  <a href="change_password.php" class="text-light">
    <div class="icon-container">
      <i class="fa fa-lock"></i>
      <span>Change password</span>
    </div>
  </a>
  <a href="../index.php" class="text-light">
    <div class="icon-container">
      <i class="fa fa-power-off "></i>
      <span>Logout</span>
    </div>
  </a>
</div>
<div id="main">
    <div id="nav-bg" class="container-fluid">
        <div class="row">
            <div class="col-lg-10 col-12">
                <h4 style="padding:20px;color:white">WORKDENT</h4>
            </div>
            <div class="col-lg-2">
                <a href="#" style="" onclick="toggleSidebar()" class="text-light bt3 "><i class="fa fa-bars "  style="font-size:30px; margin-left:10px; margin-top:20px"></i> <span></span></a>
                <span style="text-align: right; padding:20px;">
                    <a class="nav-link u-name" href="#" style="color: white;">
                        <?php
                        session_start();
                        $name = $_SESSION['name'];
                        if(isset($_SESSION['username'])) {

                            echo "Welcome " . $_SESSION['name'];
                        } else {
                            header('Location: ../index.php'); // Redirect if not logged in
                            exit();
                        }
                        ?>
                    </a>
                </span>
            </div>
        </div>
    </div>
 <div class="container mt-5">
    <div class="row">
    <div class="col-3"></div>
        <div class="col-lg-6 col-12">

            <div class="card bg-light justify-content-center">
                <h3 class="text-center mt-5">CHANGE PASSWORD</h3>

                <div class="change-password-container">
                    <form class="change-password-form" action="" method="post">
                        <div class="mb-3">
                            <input type="password" class="form-control" name="current_password" placeholder="Current Password" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="new_password" placeholder="New Password" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="confirm_new_password" placeholder="Confirm New Password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-change-password" name="change_password" style='margin-bottom:30px'>Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleSidebar() {
        var sidebar = document.getElementById('sidebar');
        var main = document.getElementById('main');

        if (sidebar.classList.contains('show')) {
            sidebar.classList.remove('show');
            main.classList.remove('shift');
        } else {
            sidebar.classList.add('show');
            main.classList.add('shift');
        }
    }
</script>

</body>
</html>
