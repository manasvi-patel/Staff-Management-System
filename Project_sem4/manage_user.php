<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "staff_scheduling";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetching HODs from the database
$sql_hods = "SELECT HOD_ID, First_Name, Last_Name FROM HOD";
$result_hods = $conn->query($sql_hods);

$hods = [];
if ($result_hods->num_rows > 0) {
    while($row = $result_hods->fetch_assoc()) {
        $hods[] = $row;
    }
}

// Adding a new professor
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_professor"])) {
    $professor_id = $_POST["professor_id"];
    $department = $_POST["department"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $courses = $_POST["courses"];
    
    $sql = "INSERT INTO Professor (P_ID, Dept_ID, First_Name, Last_Name) VALUES ('$professor_id', '$department','$first_name', '$last_name')";
    $sql1="INSERT INTO `prof_teach_course`(`P_ID`, `Course_ID`) VALUES ('$professor_id',' $courses')";
    if ($conn->query($sql) == TRUE and $conn->query($sql1) == TRUE ) {
        echo "New User added successfully";
        header("refresh:3;url=admin_dashboard.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }


}

// Deleting a professor
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_professor"])) {
    $professor_id = $_POST["professor_id"];
    
    $sql = "DELETE FROM Professor WHERE P_ID='$professor_id'";
    
    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully";
        header("refresh:3;url=admin_dashboard.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
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
            width: 100px;
            margin: 50px ;
            margin-top: 5px;
            background: #f9f9f9;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            font-size: 24px;
            margin-top: 10px;
            margin-bottom: 20px;
            margin-left: 10px;
            color: #342E37;
        }
        label {
            color: #342E37;
            font-weight: 600;
            width: 100px;
            margin-bottom: 5px;
            display: block;
        }
        input[type="text"],
        input[type="number"],
        input[type="password"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            background-color: #342E37;
            color: #fff;
            border: none;
            margin-bottom: 10px;
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

<h2>Add User</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    User ID: <input type="text" name="professor_id"><br>
    Department ID: <input type="text" name="department"><br>
    First Name: <input type="text" name="first_name"><br>
    Last Name: <input type="text" name="last_name"><br>
    Course: <input type="text" name="courses"><br>
    <input type="submit" name="add_professor" value="Add User">
</form>

<hr>

<h2>Delete User</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    User ID: <input type="text" name="professor_id"><br>
    <input type="submit" name="delete_professor" value="Delete User">
</form>

<hr>


</body>
</html>