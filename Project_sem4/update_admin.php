<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database_name = "staff_scheduling";
session_start();

// Check if user is logged in
if (!isset($_SESSION['ID'])) {
header("Location: signin.php"); // Redirect to login page if not logged in
exit();
}

// Check if request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Retrieve user ID from session
$ID = $_SESSION['ID'];
if (isset($_POST['first_name'], $_POST['last_name'], $_POST['dob'],$_POST['password'],$_POST['Street'], $_POST['City'],$_POST['State'],$_POST['Pincode'])){
// Retrieve form data
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$dob = $_POST['dob'];
$new_password = $_POST['password'];
$street = $_POST['Street'];
$city = $_POST['City'];
$state = $_POST['State'];
$pincode = $_POST['Pincode'];




// Create connection
$conn = new mysqli($servername, $username, $password, $database_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update query
$sql = "UPDATE admin SET 
        First_Name='$first_name', 
        Last_Name='$last_name', 
        A_DOB='$dob', 
        A_Password='$new_password', 
        Street='$street', 
        City='$city', 
        State ='$state', 
        Pincode='$pincode'
        WHERE A_ID='$ID'";

try {
    if ($conn->query($sql) == TRUE) {
        echo "Profile updated successfully";
        // Commit the transaction
        $conn->commit();
    } else {
        throw new Exception("Error updating profile: " . $conn->error);
    }
} catch (Exception $e) {
    echo $e->getMessage();
    // Rollback the transaction
    $conn->rollback();
}

// Close connection
$conn->close();
}
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
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
        label {
            color: #342E37;
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
        }
        input[type="text"],
        input[type="password"],
        input[type="number"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            background-color: #342E37;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #3C91E6;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Update Profile</h1>
    
    <form action="update_admin.php" method="Post">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required><br>
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required><br>
        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required><br>
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" required><br>
        <label for="Street">Street:</label>
        <input type="text" id="Street" name="Street" required><br>
        <label for="City">City:</label>
        <input type="text" id="City" name="City" required><br>
        <label for="State">State:</label>
        <input type="text" id="State" name="State" required><br>
        <label for="Pincode">Pincode:</label>
        <input type="number" id="Pincode" name="Pincode" required><br>
        <!-- Add more fields as needed -->
        <input type="submit" value="Save">
    </form>
</div>
</body>
</html>