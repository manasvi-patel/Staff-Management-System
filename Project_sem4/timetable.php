<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Timetable</title>
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
    width: 1000px;
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
table {
    width: 100%;
    border-collapse: collapse;
}
th, td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: center;
}
th {
    background-color: #f2f2f2;
}

button{
    background-color: #3C91E6;
    border: #3C91E6;
    height: 30px;
    width: 150px;
    border-radius: 5px;
}

    </style>
</head>
<body>
    <div class="container">
        <h2>Generate Timetable</h2>
        <form action="timetable.php" method="POST">
            <label for="dept_id">Enter Department ID:</label>
            <input type="text" id="dept_id" name="dept_id" required>
            <button type="submit">Generate Timetable</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Time Slot</th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                </tr>
            </thead>
            <tbody>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $dept_id = $_POST['dept_id'];
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $database_name = "staff_scheduling";

                    $conn = new mysqli($servername, $username, $password, $database_name);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Define timeslots
                    $timeslots = array("08:00 AM", "09:00 AM", "10:00 AM", "11:00 AM", "12:00 PM", "01:00 PM", "02:00 PM", "03:00 PM", "04:00 PM");

                    foreach ($timeslots as $slot) {
                        echo "<tr>";
                        echo "<td>$slot</td>";
                        for ($i = 0; $i < 5; $i++) {
                            // Fetch course and professor options
                            echo "<td><select name='course_prof[$slot][$i][course_id]'><option value=''>Select Course</option>";
                            $sql_courses = "SELECT Course_ID, Course_Name FROM Course WHERE Course_ID IN (SELECT Course_ID FROM Dept_has_Course WHERE Dept_ID = '$dept_id')";
                            $result_courses = $conn->query($sql_courses);
                            if ($result_courses->num_rows > 0) {
                                while ($row = $result_courses->fetch_assoc()) {
                                    echo "<option value='" . $row["Course_ID"] . "'>" . $row["Course_Name"] . "</option>";
                                }
                            }
                            echo "</select>";

                            echo "<select name='course_prof[$slot][$i][prof_id]'><option value=''>Select Professor</option>";
                            $sql_professors = "SELECT P_ID, First_Name, Last_Name FROM Professor WHERE Dept_ID = '$dept_id'";
                            $result_professors = $conn->query($sql_professors);
                            if ($result_professors->num_rows > 0) {
                                while ($row = $result_professors->fetch_assoc()) {
                                    echo "<option value='" . $row["P_ID"] . "'>" . $row["First_Name"] . " " . $row["Last_Name"] . "</option>";
                                }
                            }
                            echo "</select></td>";
                        }
                        echo "</tr>";
                    }

                    // Insert timetable entries into the database
                    if ($_SERVER["REQUEST_METHOD"] == "POST1") {
                        foreach ($timeslots as $slot) {
                            for ($i = 0; $i < 5; $i++) {
                                // Fetch course and professor options
                                $course_id = $_POST['course_prof'][$slot][$i]['Course_ID'];
                                $prof_id = $_POST['course_prof'][$slot][$i]['P_ID'];

                                // Insert timetable entry into the database
                                $sql_insert = "INSERT INTO Timetable (Dept_ID, Time_Slot, Day, Course_ID, Prof_ID) VALUES ('$dept_id', '$slot', '$day', '$Course_ID', '$P_ID')";
                                if ($conn->query($sql_insert) !== TRUE) {
                                    echo "Error inserting timetable entry: " . $conn->error;
                                }
                            }
                        }
                    }

                    // Close the database connection
                    $conn->close();
                }
                ?>
            </tbody>
        </table>
        <form action="timetable.php" method="POST1">
            <button type="submit">Submit</button>
        </form>
        

    </div>
</body>
</html>
