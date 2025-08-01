<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Bonus</title>
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
}
.container {
    max-width: 400px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
h2 {
    font-size: 24px;
    margin-bottom: 20px;
    color: #333;
}
label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}
input[type="text"],
input[type="number"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}
button {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    padding: 10px 20px;
    cursor: pointer;
    font-size: 16px;
}
button:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>
    <div class="container">
        <h2>Create Bonus</h2>
        

        <form action="create_bonus.php" method="POST">
            <label for="Bonus_ID">Bonus ID:</label>
            <input type="text" id="Bonus_ID" name="Bonus_ID" required><br>
            
            <label for="B_Name">Bonus Name:</label>
            <input type="text" id="B_Name" name="B_Name" required><br>
            
            <label for="B_Amount">Bonus Amount:</label>
            <input type="number" id="B_Amount" name="B_Amount" required><br>
            
            <button type="submit">Add Bonus</button>
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

// Fetch data from the form
$Bonus_ID = $_POST['Bonus_ID'];
$B_Name = $_POST['B_Name'];
$B_Amount = $_POST['B_Amount'];

// Prepare and execute INSERT statement
$sql = "INSERT INTO Bonus (Bonus_ID, B_Name, B_Amount) VALUES ('$Bonus_ID', '$B_Name', $B_Amount)";

if ($conn->query($sql) === TRUE) {
    echo "\n\n\n Bonus added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}

$conn->close();
?>
    </div>
</body>
</html>
