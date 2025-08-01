<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attendance</title>
    <!-- Include any CSS stylesheets here -->
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

        form {
            display: grid;
            grid-template-columns: 1fr 3fr;
            gap: 10px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #342E37;
        }

        input[type="text"] {
            width: calc(100% - 10px);
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="text"][readonly] {
            background-color: #f9f9f9;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: #007bff;
        }

        input[type="text"]:hover {
            border-color: #999;
        }

        .btn-container {
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>View Attendance</h1>

        <?php
        // Include your database connection file here
        $servername="localhost";
       $username="root";
       $password="";
       $database_name="staff_scheduling";
       
       $conn = new mysqli($servername, $username, $password, $database_name);
       
       if ($conn->connect_error) {
           die("Connection failed: " . $conn->connect_error);
       }
       session_start(); // Start the session to access session variables
// Check if professor ID is passed as a URL parameter

if (isset($_SESSION['ID'])) {
    // Get professor ID from the URL
     $ID=$_SESSION['ID'];

        // Assuming $conn is your database connection object

        // Query to fetch attendance data excluding D_1 to D_31 columns
        $sql = "SELECT P_ID, Total_working_days, Days_present, Days_absent, Percent_Attendance FROM Attendance WHERE P_ID = '$ID'";
        $result = $conn->query($sql);

        // Check if any rows were returned
        if ($result->num_rows > 0) {
            // Output the attendance data using a definition list
            echo "<dl>";
            // Fetching data row by row
            while ($row = $result->fetch_assoc()) {
                // Outputting data in each row
                echo "<p><strong>P_ID: </strong>" . $row['P_ID'] . "</p>";
                echo "<p><strong>Total Working Days: </strong>" . $row['Total_working_days'] . "</p>";
                echo "<p><strong>Days Present: </strong>" . $row['Days_present'] . "</p>";
                echo "<p><strong>Days Absent: </strong>" . $row['Days_absent'] . "</p>";
                echo "<p><strong>Percent Attendance: </strong>" . $row['Percent_Attendance'] . "</p>";
            }
            echo "</dl>";
        }
     } else {
            echo "No attendance data found";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>
</html>