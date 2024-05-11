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
$conn->query("SET time_zone = '+05:30'");

// Assuming form data is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle file upload
     $photos = $_FILES['photos'];
    
    // Check if files are uploaded successfully
    if (!empty($photos['name'][0])) {
        $photoNames = array();
        $photoTmpNames = $photos['tmp_name'];
    
        // Loop through each uploaded file
        foreach ($photoTmpNames as $key => $tmpName) {
            // Check if the file is uploaded successfully
            if ($photos['error'][$key] === UPLOAD_ERR_OK) {
                $photoName = $photos['name'][$key];
    
                // Move the uploaded file to a desired location
                move_uploaded_file($tmpName, "uploads/" . $photoName);
                $photoNames[] = $photoName; // Store file names in an array
            }
        }
    }
    
    // Combine file names into a comma-separated string
    $photoName = implode(",", $photoNames);

    // Escape other user inputs for security
    $clinicName = $conn->real_escape_string($_POST['clinicName']);
    $doctorName = $conn->real_escape_string($_POST['doctorName']);
    $service = $conn->real_escape_string($_POST['service']);
    $executiveName = $conn->real_escape_string($_POST['executiveName']);
    $area = $conn->real_escape_string($_POST['Area']);
    $caseid = $conn->real_escape_string($_POST['Caseid']);
    $remarks = $conn->real_escape_string($_POST['Remarks']);
    $latitude = $conn->real_escape_string($_POST['latitude']);
    $longitude = $conn->real_escape_string($_POST['longitude']);

    // Prepare SQL statement to insert data into the table
    $sql = "INSERT INTO managers (ClinicName, DoctorName, Service,  ExecutiveName, Area, Caseid, Remarks, latitude, longitude, Photo) 
            VALUES ('$clinicName', '$doctorName', '$service', '$executiveName', '$area', '$caseid', '$remarks', '$latitude', '$longitude', '$photoName')";

    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
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
     input[type="text"], select {
        text-transform: uppercase;
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

<div id="sidebar" class="">
  <a href="#" onclick="toggleSidebar()" class="text-light"><i class="fa fa-bars"></i> <span>&nbsp;  LOGO</span></a>
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

<div class="" id="main">
    <div id="nav-bg" class="container-fluid">
        <div class="row">
            <div class="col-lg-10">
                <h4 style='padding:20px;color:white'>WORKDENT</h4>
            </div>
            <div class="col-lg-2">
                <a href="#" style="" onclick="toggleSidebar()" class="text-light bt3 "><i class="fa fa-bars "  style="font-size:30px; margin-left:10px; margin-top:20px"></i> <span></span></a>
                <span style="text-align: right; padding:20px;">
                    <a class="nav-link u-name" href="#" style="color: white;">
                        <?php
                        session_start();
                        $username = $_SESSION['username'];
                        $name = $_SESSION['name'];
                        echo "Welcome " .$name;

                        function isUserLoggedIn() {
                            return isset($_SESSION['username']);
                        }

                        // Logout the user
                        function logoutUser() {
                            session_destroy();
                        }

                        // Example usage on a restricted page
                        if (!isUserLoggedIn()) {
                            // Redirect to the login page or display a message
                            header('Location: index.php');
                            exit();
                        }
                        ?>
                    </a>
                </span>
            </div>
        </div>
    </div>
    <div class="container">
    <h2 class="mt-5 mb-4">MANAGER REPORTS</h2>
    <form action="" method="post"  enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-6 mb-3">
                <label for="clinicName" class="form-label">CLINIC NAME:</label>
                <input type="text" class="form-control" id="clinicName" name="clinicName" required>
            </div>
            <div class="col-lg-6 mb-3">
                <label for="doctorName" class="form-label">DOCTOR NAME:</label>
                <input type="text" class="form-control" id="doctorName" name="doctorName" required>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 mb-3">
                <label class="form-label">AREA</label>
                <input type="text" class="form-control" name="Area" required>
            </div>
            <div class="col-lg-6 mb-3">
                <label for="service" class="form-label">SERVICE:</label>
                <select class="form-select" id="service" name="service" required>
                    <option value="">Select SERVICE</option>
                    <option value="Pick Up">PICK UP</option>
                    <option value="Delivery">DELIVERY</option>
                    <option value="Marketing-Visite">MARKETING VISIT</option>
                    <option value="Payment Follow Up">PAYMENT FOLLOW UP</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-3">
                <label class="form-label">CASE_ID</label>
                <input type="number" class="form-control" name="Caseid">
            </div>
            <div class="col-lg-6 mb-3">
                <label class="form-label">REMARKS:</label>
                <input type="text" class="form-control" name="Remarks">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 mb-3">
                <label class="form-label">Upload Photos:</label>
                <input type="file" class="form-control" name="photos[]" accept="image/*" multiple required>
            </div>
        </div>

        <!-- Hidden input fields to store the executive name and location -->
        <input type="hidden" name="executiveName" value="<?php echo $name ?>">
        <input type="hidden" name="latitude">
        <input type="hidden" name="longitude">
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
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
<script type="text/javascript">
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        }
    }

    function showPosition(position) {
        // Select the input fields correctly
        const latitudeInputs = document.querySelectorAll('input[name="latitude"]');
        const longitudeInputs = document.querySelectorAll('input[name="longitude"]');
        
        // Loop through each input field and set its value to the coordinates
        latitudeInputs.forEach(input => {
            input.value = position.coords.latitude;
        });
        longitudeInputs.forEach(input => {
            input.value = position.coords.longitude;
        });
    }

    function showError(error) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
                alert("Allow the location.");
                location.reload();
                break;
        }
        return false; // Prevent form submission
    }
</script>

</body>
</html>
