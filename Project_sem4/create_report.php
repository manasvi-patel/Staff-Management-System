<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Performance Report Form</title>
    <style>
        /* Your form styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .dashboard-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Performance Report Form</h1>
        <form action="create_report.php" method="post">
            <label for="professor_id">Professor ID:</label>
            <input type="text" id="professor_id" name="professor_id" required>

            <label for="performance">Performance:</label>
            <textarea id="performance" name="performance" rows="5" required></textarea>

            <input type="submit" value="Submit Report">

        </form>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "staff_scheduling";
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        echo "<div class='success-message'>Report submitted successfully!</div>";
        header("refresh:3;url=admin_dashboard.php");
    }
        ?>
    </div>
</body>
</html>