<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Department Courses</title>
    <link rel="stylesheet" href="styles.css">
    <style>
    body {
    font-family: Arial, sans-serif;
}

.container {
    width: 50%;
    margin: 50px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}

h2 {
    text-align: center;
}

label {
    display: block;
    margin-bottom: 10px;
}

input[type="text"], input[type="submit"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: #3C91E6;
    color: white;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color:#3C91E6;
}
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Department Courses</h2>
        <?php
// Include database connection file
$servername = "localhost";
$username = "root";
$password = "";
$database_name = "staff_scheduling";
session_start();
$conn = new mysqli($servername, $username, $password, $database_name);
// Check if user is logged in
if (!isset($_SESSION['ID'])) {
header("Location: signin.php"); // Redirect to login page if not logged in
exit();
}

// Function to insert course into department
function insertCourseInDepartment($deptID, $courseID, $conn, $course_name) {
    $sql = "INSERT INTO Dept_has_Course (Dept_ID, Course_ID) VALUES ('$deptID', '$courseID')";
    $sql1 = "INSERT INTO Course (Course_ID, Course_Name) VALUES ('$courseID', '$course_name')";
    if ($conn->query($sql) == TRUE and $conn->query($sql1) == TRUE) {
        echo "Course added to department successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Function to delete course from department
function deleteCourseFromDepartment($deptID, $courseID, $conn) {
    $sql = "DELETE FROM Dept_has_Course WHERE Dept_ID='$deptID' AND Course_ID='$courseID'";
    if ($conn->query($sql) == TRUE) {
        echo "Course removed from department successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Insert course into department
    if (isset($_POST["insert_course"])) {
        $deptID = $_POST["dept_id"];
        $courseID = $_POST["course_id"];
        $course_name = $_POST["course_name"];
        insertCourseInDepartment($deptID, $courseID, $conn, $course_name);
        header("refresh:3;url=hod_dashboard.php");
    }

    // Delete course from department
    if (isset($_POST["delete_course"])) {
        $deptID = $_POST["dept_id"];
        $courseID = $_POST["course_id"];
        deleteCourseFromDepartment($deptID, $courseID, $conn);
    }
}
?>
        <form action="manage_dept.php" method="POST">
            <label for="dept_id">Department ID:</label>
            <input type="text" id="dept_id" name="dept_id" required><br><br>

            <label for="course_id">Course ID:</label>
            <input type="text" id="course_id" name="course_id" required><br><br>

            <label for="course_name">Course Name:</label>
            <input type="text" id="course_name" name="course_name" required><br><br>
            
            <input type="submit" name="insert_course" value="Add Course">
            <input type="submit" name="delete_course" value="Remove Course">
        </form>
    </div>
</body>
</html>