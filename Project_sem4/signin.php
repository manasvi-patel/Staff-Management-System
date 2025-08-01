<?php
$servername="localhost";
$username="root";
$password="";
$database_name="staff_scheduling";

$conn = new mysqli($servername, $username, $password, $database_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$ID = $_POST['ID'];
$password = $_POST['password'];
$userType = $_POST['user-type'];

switch($userType){
    case "professor":
        // Query to check credentials
$sql = "SELECT * FROM Professor WHERE P_ID='$ID' AND P_Password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Login successful
    session_start();
    $_SESSION['ID'] = $ID;
    $_SESSION['user_type'] = $userType;
    header("Location: professor_dashboard.php"); // Redirect to dashboard or any other page
}
    case "hod":
        $sql = "SELECT * FROM HOD WHERE HOD_ID='$ID' AND HOD_Password='$password'";
        $result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Login successful
    session_start();
    $_SESSION['ID'] = $ID;
    $_SESSION['user_type'] = $userType;
    header("Location: hod_dashboard.php"); // Redirect to dashboard or any other page
}
    case "time-table-coordinator":
        $sql = "SELECT * FROM TTCORD WHERE TTC_ID='$ID' AND TTC_Password='$password'";
        $result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Login successful
    session_start();
    $_SESSION['ID'] = $ID;
    $_SESSION['user_type'] = $userType;
    header("Location: ttc_dashboard.php"); // Redirect to dashboard or any other page

    }
    case "finance":
        $sql = "SELECT * FROM Financer WHERE F_ID='$ID' AND F_Password='$password'";
        $result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Login successful
    session_start();
    $_SESSION['ID'] = $ID;
    $_SESSION['user_type'] = $userType;
    header("Location: finance_dashboard.php"); // Redirect to dashboard or any other page
}
    case "admin":
        $sql = "SELECT * FROM Admin WHERE A_ID='$ID' AND A_Password='$password'";
        $result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Login successful
    session_start();
    $_SESSION['ID'] = $ID;
    $_SESSION['user_type'] = $userType;
    header("Location: admin_dashboard.php"); // Redirect to dashboard or any other page
}

    default: 
    // Login failed
    echo "Invalid id or password";


}


$conn->close();
?>
