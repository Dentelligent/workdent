 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Executive Management Systems</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
              
        }
        .fa {
            font-size: 25px;
        }
        a{
        text-decoration: none;
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
        #sidebar a:hover {
            color: #3ADCCE;
        }
        #main {
            margin-left: 80px; /* Adjusted margin-left */
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
            .bt3{
        display:none;
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
            .bt3{
                display:inline-block;
             }
        }
        
    </style>
</head>
<body>

<div id="sidebar" class="">
    <a href="#" onclick="toggleSidebar()" class="text-light"><i class="fa fa-bars"></i><span>&nbsp;  LOGO</span></a>
    <a href="welcome.php" class="text-light">
        <div class="icon-container">
            <i class="fa fa-home"></i>
            <span>Home</span>
        </div>
    </a>
      <a href="user_details.php" class="text-light">
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
            <span>Add New</span>
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
            <i class="fa fa-power-off"></i>
            <span>Logout</span>
        </div>
    </a>
    <!-- Add more icon links with names as needed -->
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
                        if(isset($_SESSION['username'])) {
                            echo "Welcome " . htmlspecialchars($_SESSION['name']);
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

    <div class="container mt-5" style="overflow-x:auto; ">
         <?php
        $servername = "localhost";
        $username = "u170552379_admin";
        $password = "DENTELLIGENt@2019";
        $dbname = "u170552379_workdent";

        // Establish the database connection
        $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute SQL query
        $sql = "SELECT id, username, password, user_type, name, referTo, number, address FROM logins WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $_SESSION['username']);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check for errors
        if ($result === false) {
            echo "Error: " . $conn->error;
        } else {
            if ($result->num_rows > 0) {
                // Output data of each row
                echo "<div class='details'>";
                while($row = $result->fetch_assoc()) {
                    echo "<div class='detail-item'>";
                    echo "<strong>ID:</strong> " . $row["id"]. "<br>";
                    echo "<strong>Username:</strong> " . $row["username"]. "<br>";
                    echo "<strong>Name:</strong> " . $row["name"]. "<br>";
                    echo "<strong>Refer To:</strong> " . $row["referTo"]. "<br>";
                    echo "<strong>Number:</strong> " . $row["number"]. "<br>";
                    echo "<strong>Address:</strong> " . $row["address"]. "<br>";
                    echo "</div>"; // detail-item
                }
                echo "</div>"; // details
            } else {
                echo "0 results";
            }
        }

        // Close the database connection
        $stmt->close();
        $conn->close();
        ?>
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
