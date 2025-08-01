<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <h1><i class='bx bxs-user-circle'></i></h1>
        <h2> LOGIN </h2>
        <form id="login-form" action="signin.php" method="POST">
            <div class="form-group">
                <label for="ID">Identification Number</label>
                <input type="ID" id="ID" name="ID" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="user-type">Select User Type:</label>
                <select id="user-type" name="user-type">
                    <option value="professor">Professor</option>
                    <option value="hod">HOD</option>
                    <option value="time-table-coordinator">Time Table Coordinator</option>
                    <option value="finance">Finance</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form-group remember-me-group">
                <input type="checkbox" id="remember-me" name="remember-me">
                <label for="remember-me">Remember Me</label>
            </div>
            
            <div class="form-group">
                <a href="forgot.html" class="forgot-password">Forgot Password?</a>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
