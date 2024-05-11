<?php
// Check if the form is submitted and ID is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ID'])) {
    $appointment_id = $_POST['ID']; // Corrected to use 'ID' instead of 'id'

    // Your database connection details
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

    // Fetch updated data from the form
    $clinicName = $_POST['ClinicName'];
    $doctorName = $_POST['DoctorName'];
    $service = $_POST['Service'];
    $area = $_POST['Area'];
    $caseId = $_POST['Caseid'];
    $remarks = $_POST['Remarks'];

    $sql = "UPDATE managers SET 
        ClinicName='$clinicName', 
        DoctorName='$doctorName', 
        Service='$service', 
        Area='$area', 
        Caseid='$caseId', 
        Remarks='$remarks'
     
        WHERE ID='$appointment_id'";

            
    if ($conn->query($sql) === TRUE) {
     // Redirect to welcome.php after successful update
            header("Location: welcome.php");
            exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    echo "ID not set or form not submitted.";
}
?>
