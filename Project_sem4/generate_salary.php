<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Salary</title>
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
    width: 600px;
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

input[type="text"], input[type="submit"], input[type="number"] {
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
    background-color:darkblue;
}

select{
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}
    </style>
</head>
<body>
    <div class="container">
    <h2>Generate Salary</h2>
    <form action="generate_salary.php" method="POST">
        <label for="Salary_ID">Salary ID :</label>
        <input type="text" id="Salary_ID" name="Salary_ID" required><br><br>

        <label for="P_ID">Professor ID :</label>
        <input type="text" id="P_ID" name="P_ID" required><br><br>
        
        <label for="TA">Travel Allowance :</label>
        <input type="number" id="TA" name="TA" required><br><br>
        
        <label for="DA">Dearness Allowance :</label>
        <input type="number" id="DA" name="DA" required><br><br>
        
        <label for="Basic_Amt">Basic Amount :</label>
        <input type="number" id="Basic_Amt" name="Basic_Amt" required><br><br>
        
        <label for="Bonus_ID">Bonus:</label>
        <select id="Bonus_ID" name="Bonus_ID"><br><br>
            <?php
            // Database connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "staff_scheduling";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch bonus names from Bonus table
            $sql = "SELECT Bonus_ID, B_Name FROM Bonus";
            $result = $conn->query($sql);

            // Display bonus names in dropdown
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["Bonus_ID"] . "'>" . $row["B_Name"] . "</option>";
                }
            }
            ?>
        </select><br>
        
        <input type="submit" value="Submit">
    </form>
    <?php

    
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "staff_scheduling";
                session_start();

                // Check if user is logged in
                if (!isset($_SESSION['ID'])) {
                header("Location: finance_dashboard.php"); // Redirect to login page if not logged in
                exit();
                }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Fetch data from the form
        $Salary_ID = $_POST['Salary_ID'];
        $P_ID = $_POST['P_ID'];
        $TA = $_POST['TA'];
        $DA = $_POST['DA'];
        $Basic_Amt = $_POST['Basic_Amt'];
        $Bonus_ID = $_POST['Bonus_ID'];
        $ID = $_SESSION['ID'];


        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare an INSERT statement
$sql = "INSERT INTO `salary`(`Salary_ID`, `P_ID`, `TA`, `DA`,`F_ID`, `Bonus_ID`, `basic_amt`) VALUES (?,?,?,?,?,?,?)";

// Use prepared statements to prevent SQL injection
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param("sssssss", $Salary_ID, $P_ID, $TA,$DA,$F_ID,$Bonus_ID,$Basic_Amt);

$stmt->execute();

// Check if the insertion was successful
if ($stmt->affected_rows > 0) {
    echo "New record inserted successfully\n";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close statement and connection
$stmt->close();

       // Call the stored procedure to calculate total salary
       $sql = "CALL CalculateTotalSalaryWithBonus()";

       if ($conn->query($sql) === TRUE) {
           echo "Total salary calculated successfully<br>";
           $sql = "SELECT s.P_ID, s.Total_Salary, s.TA, s.DA, s.Basic_Amt, b.B_Name, b.B_Amount
           FROM Salary s
           LEFT JOIN Bonus b ON s.Bonus_ID = b.Bonus_ID
           WHERE F_ID = '$ID'";
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
           echo "Error: " . $sql . "<br>" . $conn->error;
       }



     
   }
   $conn->close();
   ?>
</div>
</body>
</html>