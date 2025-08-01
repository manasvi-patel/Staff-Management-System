<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary and Bonus Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: inline-block;
            width: 150px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"] {
            width: calc(100% - 170px);
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="text"]:read-only {
            background-color: #f9f9f9;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Salary and Bonus Information</h1>

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
       session_start(); // Start the session to access session variables
// Check if professor ID is passed as a URL parameter

if (isset($_SESSION['ID'])) {
    // Get professor ID from the URL
     $ID=$_SESSION['ID'];

        // Assuming $conn is your database connection object

        // Query to fetch salary and bonus information
        $sql = "SELECT s.P_ID, s.Total_Salary, s.TA, s.DA, s.Basic_Amt, b.B_Name, b.B_Amount
                FROM Salary s
                LEFT JOIN Bonus b ON s.Bonus_ID = b.Bonus_ID
                WHERE P_ID = '$ID'";
        $result = $conn->query($sql);

        // Check if any rows were returned
        if ($result->num_rows > 0) {
            // Fetching data row by row
            while ($row = $result->fetch_assoc()) {
                // Outputting data in form format
                echo "<div class='form-group'>";
                echo "<label>Professor ID:</label> <input type='text' value='" . $row['P_ID'] . "' readonly><br>";
                echo "<label>Total Salary:</label> <input type='text' value='" . $row['Total_Salary'] . "' readonly><br>";
                echo "<label>Travel Allowance (TA):</label> <input type='text' value='" . $row['TA'] . "' readonly><br>";
                echo "<label>Dearness Allowance (DA):</label> <input type='text' value='" . $row['DA'] . "' readonly><br>";
                echo "<label>Basic Amount:</label> <input type='text' value='" . $row['Basic_Amt'] . "' readonly><br>";
                echo "<label>Bonus Name:</label> <input type='text' value='" . $row['B_Name'] . "' readonly><br>";
                echo "<label>Bonus Amount:</label> <input type='text' value='" . $row['B_Amount'] . "' readonly><br>";
                echo "</div>";
            }
        }
     } else {
            echo "<p>No salary and bonus information found</p>";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>
</html>