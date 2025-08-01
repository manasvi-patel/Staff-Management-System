<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #eee;
            overflow-x: hidden;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #f9f9f9;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #342E37;
        }
        p {
            margin-bottom: 10px;
            color: #666;
        }
        strong {
            color: #342E37;
        }

        button{
            background-color: #3C91E6;
            text-align: center;
            font-size: 18px;
            font-family: 'Poppins', sans-serif;
            border-color: #3C91E6;
            border-radius: 5px;
            width: 150px;
            height: 40px;
            color: white;
        }
    </style>
</head>
<body>
<div class="container">
        <h1>Profile Information</h1>
        <?php
        // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database_name = "staff_scheduling";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database_name);
session_start(); // Start the session to access session variables
// Check if professor ID is passed as a URL parameter

if (isset($_SESSION['ID'])) {
    // Get professor ID from the URL
     $ID=$_SESSION['ID'];
    //  $ID='PROF000002';

    

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "<p><strong>User ID:</strong> $ID</p>";


    // Query to retrieve data from the database based on professor_id
    $sql = "SELECT * FROM HOD WHERE HOD_ID = '$ID'";
    $sql1 = "SELECT * FROM HOD_Email WHERE HOD_ID = '$ID'";
    $sql2 = "SELECT * FROM HOD_Mobile WHERE HOD_ID = '$ID'";
    $result = $conn->query($sql);
    $result1 = $conn->query($sql1);
    $result2 = $conn->query($sql2);

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Output data of the professor
        $row = $result->fetch_assoc();
        $row1 = $result1->fetch_assoc();
        $row2 = $result2->fetch_assoc();
        echo "<div class='container'>";
        echo "<h1>Profile Information</h1>";
        echo "<p><strong>HOD ID:</strong> " . $row["HOD_ID"]. "</p>";
        echo "<p><strong>First Name:</strong> " . $row["First_Name"]. "</p>";
        echo "<p><strong>Last Name:</strong> " . $row["Last_Name"]. "</p>";
        echo "<p><strong>Date of Joining:</strong> " . $row["HOD_DOJ"]. "</p>";
        echo "<p><strong>Date of Birth:</strong> " . $row["HOD_DOB"]. "</p>";
        echo "<p><strong>Password:</strong> " . $row["HOD_Password"]. "</p>";
        echo "<p><strong>Department ID:</strong> " . $row["Dept_ID"]. "</p>";
        echo "<p><strong>Street:</strong> " . $row["Street"]. "</p>";
        echo "<p><strong>City:</strong> " . $row["City"]. "</p>";
        echo "<p><strong>State:</strong> " . $row["State"]. "</p>";
        echo "<p><strong>Pincode:</strong> " . $row["Pincode"]. "</p>";
        echo "<p><strong>Email:</strong> " . $row1["HOD_Email"]. "</p>";
        echo "<p><strong>Mob No:</strong> " . $row2["HOD_Mobile"]. "</p>";
        echo "</div>";
        $conn->close();
        // Add more fields as needed
    }
 } else {
        echo "No professor found with the provided ID.";
    }
    

?>
<a href="update_hod.php"><button>Update Profile</button></a>
    </div>
</body>
</html>
