
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
  <a href="manager_form.php" class="text-light">
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

                            echo "Welcome " .$name;
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
 <div class="container-fluid  custom-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 style="margin-left:20px">Manager visits</h2>
              <div class="row">
                <div class="col-lg-6">
                    <div class="search-box">
                <input type="text" class="form-control" placeholder="Search...">
                
            </div>
                </div>
                <div class="col" id="printButtonWrapper">
                  <i onclick="window.print()" class="fa fa-print" style="font-size:24px"></i>

                </div>

                <div class="col">
                    <a href="managerform_update.php?name=<?php echo urlencode($name); ?>">
                        <button class="search-box btn btn-primary">Edit</button>
                    </a>
                </div>

            </div>
            
        </div>
    <div class="container-fluid mt-5" style="overflow-x:auto; ">
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

             // Fetch appointment details
        $sql = "SELECT * from managers  WHERE ExecutiveName = '$name' ORDER BY id DESC";
        
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            echo "<table class='table table-bordered'>";
            echo "<thead class='table-dark'><tr><th>ID </th><th>DATE & TIME </th><th>CLINIC NAME</th><th>DOCTOR NAME</th><th>AREA</th><th>SERVICE TYPE</th><th>CASE ID</th><th>EXECUTIVE NAME</th><th>REMARKS</th><th>LOCATION</th><th>Photo</th></tr></thead><tbody>";
            while($row = $result->fetch_assoc()) {
                $originalDate = $row["AppointmentDateTime"]; // Assuming $row["AppointmentDateTime"] contains "2024-03-17 13:07:46"
                $formattedDate = date("d-M-Y H:i", strtotime($originalDate));
                
                             // Split the comma-separated string into an array
                $photoNames = explode(",", $row['Photo']);
            
                // Initialize an empty string to store the HTML code for the images
                $imageLinks = '';
            
                // Counter for image numbers
                $imageNumber = 1;
            
                // Loop through each file name and generate HTML code for the image links
                foreach ($photoNames as $photoName) {
                    // Concatenate the HTML code for each image link along with its number
                    $imageLinks .= "<a href='uploads/" . $photoName . "' target='_blank'>Image " . $imageNumber . "</a><br>";
                    $imageNumber++; // Increment image number
                }
                
                echo "<tr><td>" . strtoupper($row["id"]). "</td><td>" . strtoupper($formattedDate). "</td><td>" . strtoupper($row["ClinicName"]). "</td><td>" . strtoupper($row["DoctorName"]). "</td><td>" . strtoupper($row["Area"]). "</td><td>" . strtoupper($row["Service"]). "</td><td>" .   strtoupper($row["Caseid"]). "</td><td>" . strtoupper($row["ExecutiveName"]). "</td><td>" . strtoupper($row["Remarks"]). "</td><td><a href='https://maps.google.com/maps?q=" . $row['Latitude'] . "," . $row['Longitude'] . "&hl=es&z=14' target='_blank'> Location URL</a></td><td>" .  $imageLinks. "</td></tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p class='text-danger'>No appointment details found</p>";
        }
        
        // Close the database connection
        $conn->close();
        ?>

    </div>
</div>
</div>
<style>
@media print {
 
  .table {
    display: block !important;
  }
  #sidebar{
      display:none;
  }
  #nav-bg{
       display:none;
  }
}
</style>
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
