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

// Prepare variables for message display
$message = "";
$messageClass = "";

// Check if the 'matric' is provided in the query string
if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];

    // Perform the delete operation
    $sql = "DELETE FROM users WHERE matric = '$matric'";

    if ($conn->query($sql) === TRUE) {
        $message = "User deleted successfully!";
        $messageClass = "success";
        header("Location: display.php"); // Redirect back to display.php after deletion
        exit;
    } else {
        $message = "Error deleting user: " . $conn->error;
        $messageClass = "error";
    }
} else {
    $message = "Invalid request!";
    $messageClass = "error";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
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

        .message-container {
            text-align: center;
            background: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .message-container h2 {
            margin-bottom: 20px;
            font-size: 18px;
        }

        .success {
            color: #28a745;
        }

        .error {
            color: #dc3545;
        }

        a {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="message-container">
        <h2 class="<?php echo $messageClass; ?>"><?php echo $message; ?></h2>
        <a href="display.php">Go Back to Users List</a>
    </div>
</body>
</html>
