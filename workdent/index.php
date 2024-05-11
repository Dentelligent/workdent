
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

// Check for an existing session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user-provided details from the form
    $userProvidedUsername = $_POST['username'];
    $userProvidedPassword = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, username, user_type, name FROM logins WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $userProvidedUsername, $userProvidedPassword);
    $stmt->execute();

    // Check if a row is returned
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Username and password are correct
        $row = $result->fetch_assoc();
        $user_type = $row['user_type'];
        $name =  $row['name'];
        
        // Set session variables before redirection
        $_SESSION['username'] = $userProvidedUsername;
        $_SESSION['name'] = $name;

        // Close the statement
        $stmt->close();

        // Regenerate session ID
        session_regenerate_id(true);

        // Redirect based on user type
        switch ($user_type) {
            case "admin":
                header("Location: admin/welcome.php");
                break;
            case "user":
                header("Location: user/user_form.php");
                break;
            case "manager":
                header("Location: manager/welcome.php");
                break;
            default:
                // Default redirection for other user types
                header("Location: user/user_form.php");
                break;
        }
        exit();
    } else {
        // Invalid username or password
        $error = "Invalid username or password";
        echo "<script type='text/javascript'>alert('" . $error . "');</script>";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<!-- Desigined and Developed by Soma Sekhar Chedalla  contact - 9676183321  -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
     <link rel="icon" type="image/x-icon" href="images/dentelligent new logo.gif">
    <style>
        body {
        background-color:#086DEB;
        }
     .justify-content-center{
         margin-top:30px;
     }
        .card {
            border-radius: 20px;
            
        }

        .card-header {
            border-radius: 10px 10px 0 0;
            color:#086DEB ;
        }

        .login-button {
            background-color: #086DEB;
            border: none;
            border-radius: 20px;
            margin-left:42%;
            color: white;
            padding: 10px 20px;
            cursor: pointer;
            box-shadow: 0 12px 20px rgba(0,0,0,0.3), 0 0 0 4px #fff; 
            transition: background-color 0.3s;
        }

        .login-button:hover {
            background-color: #0056b3;
        }
         @media (max-width: 768px) {
            .justify-content-center{
             margin-top:2px;
         }
         }
    </style>
</head>

<body>
 
    <div class="container-fluid">
        <div class="row mt-5"  "justify-content-center">
             <div class="col-lg-6 ">
                <img src="images/DDS BREATHE 15S.gif" alt="Dentelligent Workforce Management" width="100%" height="100%">
            </div>
            
            <div class="col-md-4 mt-3">
                <div class="card mt-3">
                    <div class="card-header">
                        <h2 class="m-1">WORKDENT</h2>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="form-group container">
                                <div class="row">
                                    <div calss="col-lg-2 col-2">
                                         <i class="fa fa-user" style="font-size:36px"></i>
                                    </div>
                                    <div class="col-lg-10 col-10">
                                       <input type="text" class="form-control" name="username" placeholder="Username" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group container">
                                <div class="row">
                                    <div calss="col-lg-2 col-2">
                                        <i class="fa fa-lock" style="font-size:40px"></i>
                                    </div>
                                    <div class="col-lg-10 col-10">
                                        <input type="password" class="form-control" id="passwordInput" name="password" placeholder="Password" required>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-lg-5 col-10">
                                        <input type="checkbox" id="showPasswordCheckbox">
                                        <label for="showPasswordCheckbox">Show Password</label>
                                    </div>
                                     <div class="col-lg-7 "></div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary login-button">Login</button>
                        </form>
                    </div>
                </div>
            </div>
             <div class="col-lg-2"></div>
        </div>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get references to the password input and the checkbox
        const passwordInput = document.getElementById("passwordInput");
        const showPasswordCheckbox = document.getElementById("showPasswordCheckbox");

        // Function to toggle the password visibility
        function togglePasswordVisibility() {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }

        // Add event listener to the checkbox
        showPasswordCheckbox.addEventListener("click", togglePasswordVisibility);
    });
</script>
</body>

</html>
