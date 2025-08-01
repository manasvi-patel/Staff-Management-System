<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Application Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        form {
            max-width: 300px;
            margin: 0 auto;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        select,
        input[type="date"],
        input[type="submit"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .success-message {
            text-align: center;
            color: #4CAF50;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Leave Application Form</h2>

        <?php
        session_start();

        if (isset($_SESSION['ID'])) {
            $professor_id = $_SESSION['ID'];

            if (isset($_POST['leave_type'], $_POST['from_date'], $_POST['to_date'])) {
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database_name = "staff_scheduling";

                $conn = new mysqli($servername, $username, $password, $database_name);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $leave_type = $_POST['leave_type'];
                $from_date = $_POST['from_date'];
                $to_date = $_POST['to_date'];

                $query = "INSERT INTO Leaves (Leave_ID, to_date, from_date, leave_type, P_ID) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $leave_id = "LEAVE" . sprintf('%05d', rand(0, 99999));
                $stmt->bind_param("sssss", $leave_id, $to_date, $from_date, $leave_type, $professor_id);

                if ($stmt->execute()) {
                    echo "<div class='success-message'>Leave application submitted successfully!</div>";
                    header("refresh:3;url=professor_dashboard.php"); // Redirect to dashboard after 3 seconds
                    exit();
                } else {
                    echo "Error: " . $conn->error;
                }

                $stmt->close();
                $conn->close();
            }
        } else {
            header("Location: login.php");
            exit();
        }
        ?>

        <form action="applyleave.php" method="POST">
            <label for="leave_type">Leave Type:</label>
            <select name="leave_type" id="leave_type">
                <option value="Sick Leave">Sick Leave</option>
                <option value="Vacation Leave">Vacation Leave</option>
                <option value="Sabbatical Leave">Sabbatical Leave</option>
                <option value="Personal Leave">Personal Leave</option>
                <option value="Maternity Leave">Maternity Leave</option>
                <!-- Add more leave types if needed -->
            </select><br><br>
            <label for="from_date">From Date:</label>
            <input type="date" id="from_date" name="from_date"><br><br>
            <label for="to_date">To Date:</label>
            <input type="date" id="to_date" name="to_date"><br><br>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
