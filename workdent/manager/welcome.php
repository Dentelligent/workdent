<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WORK FORCE MANAGEMENT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Ariel', sans-serif;
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
    <a href="#" onclick="toggleSidebar()" class="text-light"><i class="fa fa-bars"></i><span>&nbsp;  MENU</span></a>
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
                Personal  Details
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
                <h3 style="padding:40px;color:yellow">WORKDENT</h3>
            </div>
            <div class="col-lg-2">
                <a href="#" style="" onclick="toggleSidebar()" class="text-light bt3 "><i class="fa fa-bars "  style="font-size:30px; margin-left:10px; margin-top:20px"></i> <span></span></a>
                <span style="text-align: right; padding:20px;">
                    <a class="nav-link u-name" href="#" style="color: yellow;">
                        <?php
                        session_start();
                        $name = $_SESSION['username'];
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
</div>

<div class="container">
    <div class="container mt-5">
        <div class="row">
             <div class="col-lg-2"></div>
            <div class="col-lg-4">
                 <a href="executive_reports.php"><button class="btn btn-primary p-4  mt-5 "> EXECUTIVE REPORTS  </button></a>
                 
            </div>
            <div class="col-lg-4 col-12">
                 <a href="manager_info.php"><button class="btn btn-primary  p-4 mt-5">MANAGER  REPORTS  </button></a>
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
