
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
    .custom-container {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .search-box {
            float: right;
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
    }
  </style>
</head>
<body onload="getLocation();">

<div id="sidebar" class=" ">
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
            <div class="col-10">
                <h4 style="padding:20px;color:white">WORKDENT</h4>
            </div>
            <div class="col-2">
                <span style="text-align: right; padding:20px;">
                    <a class="nav-link u-name" href="#" style="color: white;">
                        <?php
                        session_start();
                        if(isset($_SESSION['username'])) {
                            echo "Welcome " . $_SESSION['name'];
                        } else {
                            header('Location: index.php'); // Redirect if not logged in
                            exit();
                        }
                        
                        ?>
                    </a>
                </span>
            </div>
        </div>
    </div>
<div class="container mt-5">
    <h2>Edit Appointment</h2>
    <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group row">
            <div class="col-lg-6">
                <label class="form-label " for="id">Enter Appointment ID:</label>
                <input type="text" class="form-control" id="id" name="id" placeholder="Enter ID">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-4">Submit</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
        $appointment_id = $_GET['id'];

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

        // Fetch appointment details
        $sql = "SELECT ClinicName	,
                ID,
                DoctorName	,
                Service	,
                Area	,
                Caseid	,
                Remarks	
               	 FROM executives WHERE id = '$appointment_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>
            <form class="mt-5" method="post" action="update_userform.php">
               
                <div class="row">
                    <?php
                    foreach ($row as $key => $value) {
                        ?>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label  class="form-label" for="<?php echo $key; ?>"><?php echo ucfirst($key); ?>:</label>
                                <input type="text" class="form-control" id="<?php echo $key; ?>" name="<?php echo $key; ?>" value="<?php echo $value; ?>">
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <button type="submit" class="btn btn-primary mt-4">Update</button>
            </form>
            <?php
        } else {
            echo "<p class='text-danger mt-3'>Appointment with ID $appointment_id not found</p>";
        }

        // Close the database connection
        $conn->close();
    }
    ?>
</div>
<script>
    function toggleSidebar() {
        var sidebar = document.getElementById('sidebar');
        var main = document.getElementById('main');
        var links = document.querySelectorAll('#sidebar a span');

        if (sidebar.style.width === '80px') {
            sidebar.style.width = '200px';
            main.style.marginLeft = '200px';
            links.forEach(link => (link.style.display = 'inline-block'));
        } else {
            sidebar.style.width = '80px';
            main.style.marginLeft = '80px';
            links.forEach(link => (link.style.display = 'none'));
        }
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  $(document).ready(function () {
    $(".search-box input").on("keyup", function () {
      var value = $(this).val().toLowerCase();
      $("table tbody tr").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
      });
    });
  });
</script>
</body>
</html>
