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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set
    if(isset($_POST['ID']) && isset($_POST['new_caseid'])){
        // Sanitize inputs to prevent SQL injection
        $ID = mysqli_real_escape_string($conn, $_POST['ID']);
        $newCaseid = mysqli_real_escape_string($conn, $_POST['new_caseid']);
        
        // SQL query to update the record with the provided ID
        $sql = "UPDATE executives SET Caseid = '$newCaseid' WHERE ID = '$ID'";
        
        if ($conn->query($sql) === TRUE) {
            // Redirect to welcome.php after successful update
            header("Location: welcome.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
    else{
        echo "ID and New Caseid are required!";
    }
}

// Close the database connection
$conn->close();
?>
