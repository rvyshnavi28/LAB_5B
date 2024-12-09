<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input:focus {
            outline: none;
            border-color: #007bff;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        a:hover {
            color: #0056b3;
        }

        .link-container {
            text-align: center;
            margin-top: 15px;
        }

        .message {
            text-align: center;
            margin-top: 10px;
            color: red;
        }
    </style>
</head>
<body>
    <form method="POST" action="login.php">
        <h2 style="text-align: center; color: #007bff;">Login</h2>
        <label>Matric Number:</label>
        <input type="text" name="matric" required>
        
        <label>Password:</label>
        <input type="password" name="password" required>
        
        <button type="submit" name="login">Login</button>
        
        <div class="link-container">
            <a href="register.php">Register</a> <label>if you have not</label>
        </div>
    </form>

    <?php
    session_start();

    if (isset($_POST['login'])) {
        // Connect to the database
        $conn = new mysqli('localhost', 'root', '', 'lab_5b');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get the form data
        $matric = $_POST['matric'];
        $password = $_POST['password'];

        // Query the database
        $stmt = $conn->prepare("SELECT * FROM users WHERE matric = ?");
        $stmt->bind_param("s", $matric);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the user exists
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                header("Location: display.php"); // Redirect to the page
                exit;
            } else {
                echo "<p class='message'>Incorrect password!</p>";
            }
        } else {
            echo "<p class='message'>User not found!</p>";
        }

        // Close the database connection
        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>
