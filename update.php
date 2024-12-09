<?php 
// Start session and check authentication
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'lab_5b');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the 'matric' from the query string
if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];

    // Fetch the user's existing details
    $result = $conn->query("SELECT * FROM users WHERE matric = '$matric'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found!";
        exit;
    }
} else {
    echo "Invalid request!";
    exit;
}

// Update user details when the form is submitted
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $accessLevel = $_POST['accessLevel'];

    $sql = "UPDATE users SET name = '$name', accesslevel = '$accessLevel' WHERE matric = '$matric'";

    if ($conn->query($sql) === TRUE) {
        echo "User details updated successfully!";
        header("Location: display.php"); // Redirect to display page after update
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
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

        .form-container {
            background: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input, select {
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

        .message {
            text-align: center;
            margin-top: 10px;
            color: red;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Update User Details</h2>
        <form method="POST" action="">
            <label>Matric Number:</label>
            <input type="text" name="matric" value="<?php echo $user['matric']; ?>" readonly>

            <label>Name:</label>
            <input type="text" name="name" value="<?php echo $user['name']; ?>" required>

            <label>Role:</label>
            <select name="accessLevel" required>
                <option value="Lecturer" <?php echo ($user['accesslevel'] == 'Lecturer') ? 'selected' : ''; ?>>Lecturer</option>
                <option value="Student" <?php echo ($user['accesslevel'] == 'Student') ? 'selected' : ''; ?>>Student</option>
            </select>

            <button type="submit" name="update">Update</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
