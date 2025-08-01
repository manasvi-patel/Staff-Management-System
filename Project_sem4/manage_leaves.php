<!DOCTYPE html>
<html>
<head>
    <title>Leave Approval by HOD</title>
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
        h2 {
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
        select,
        input[type="text"],
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

<h2>Leave Approval by HOD</h2>
<?php
// Database connection details (replace with your actual database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$database_name = "staff_scheduling";

// Create connection
$conn = new mysqli($servername, $username, $password, $database_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch leave IDs with null status
$sql_leave_ids = "SELECT Leave_ID FROM Leaves WHERE status IS NULL";
$result_leave_ids = $conn->query($sql_leave_ids);

if ($result_leave_ids->num_rows > 0) {
    echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
    echo "<label for='leave_id'>Select Leave ID:</label>";
    echo "<select id='leave_id' name='leave_id' required>";
    while ($row = $result_leave_ids->fetch_assoc()) {
        echo "<option value='" . $row["Leave_ID"] . "'>" . $row["Leave_ID"] . "</option>";
    }
    echo "</select><br><br>";
    echo "<input type='submit' value='Show Details'>";
    echo "</form>";
} else {
    echo "No leaves pending approval.";
}

// Display leave details if a leave ID is selected
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["leave_id"])) {
    $leaveID_selected = $_POST["leave_id"];

    // Fetch leave details based on the selected leave ID
    $sql_leave_details = "SELECT * FROM Leaves WHERE Leave_ID = '$leaveID_selected'";
    $result_leave_details = $conn->query($sql_leave_details);

    if ($result_leave_details->num_rows > 0) {
        echo "<h3>Leave Details:</h3>";
        echo "<table border='1'>";
        while ($row = $result_leave_details->fetch_assoc()) {
            echo "<tr><td>Leave ID:</td><td>" . $row["Leave_ID"] . "</td></tr>";
            echo "<tr><td>From Date:</td><td>" . $row["from_date"] . "</td></tr>";
            echo "<tr><td>To Date:</td><td>" . $row["to_date"] . "</td></tr>";
            echo "<tr><td>Leave Type:</td><td>" . $row["leave_type"] . "</td></tr>";
            // You can display more leave details as needed
        }
        echo "</table>";

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["decision"])&& isset($_POST["leave_id"])) {
            // Process the form data
            $decision = $_POST["decision"];

            // Perform validation and processing here
            // Example: Update leave status in the database
            $sql = "UPDATE Leaves SET status = '$decision' WHERE Leave_ID = '$leaveID_selected'";

            try {
                if ($conn->query($sql) == TRUE) {
                    echo "Leave ID $leaveID_selected has been $decision successfully updated.";
                } else {
                    throw new Exception("Error updating record: " . $conn->error);
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        ?>
        <form method="Post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="leave_id" value="<?php echo $leaveID_selected; ?>">
            <label for="decision">Decision:</label>
            <select id="decision" name="decision" required>
                <option value="rejected">Reject</option>
                <option value="approved">Approve</option>
            </select><br><br>
            <input type="submit" value="Submit Decision">
        </form>
        <?php
    } else {
        echo "No leave details found for the selected leave ID.";
    }
}

// Close the database connection
$conn->close();
?>

</div>

</body>
</html>
