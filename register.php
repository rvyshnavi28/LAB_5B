<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #007bff;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background-color: #0056b3;
        }

        .secondary-btn {
            background-color: #6c757d;
        }

        .secondary-btn:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <form method="POST" action="register.php">
        <h2 style="text-align: center; color: #007bff;">Register</h2>
        <label>Matric Number:</label>
        <input type="text" name="matric" required>

        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Role:</label>
        <select name="accessLevel" required>
            <option value="" disabled selected>Please select</option>
            <option value="Lecturer">Lecturer</option>
            <option value="Student">Student</option>
        </select>

        <label>Password:</label>
        <input type="password" name="password" required>

        <button type="submit" name="submit">Register</button>
    </form>

    <!-- Add Login Button -->
    <form method="GET" action="login.php" style="margin-top: 20px; text-align: center;">
        <button type="submit" class="secondary-btn">Go to Login</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $conn = new mysqli('localhost', 'root', '', 'lab_5b'); // Connect to DB

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $matric = $conn->real_escape_string($_POST['matric']);
        $name = $conn->real_escape_string($_POST['name']);
        $accessLevel = $conn->real_escape_string($_POST['accessLevel']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO users (matric, name, accessLevel, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $matric, $name, $accessLevel, $password);

        if ($stmt->execute()) {
            echo "<p style='text-align: center; color: green;'>Registration successful!</p>";
        } else {
            echo "<p style='text-align: center; color: red;'>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>
