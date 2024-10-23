<?php
$servername = "database-1.c5k4ul5ztjqm.us-east-1.rds.amazonaws.com"; // RDS Endpoint
$username = "admin"; // Your RDS username
$password = "vinay2608"; // Your RDS password
$dbname = "musicapp"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname) VALUES (?, ?)");
    $stmt->bind_param("ss", $firstname, $lastname);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
</head>
<body>
    <h2>User Registration</h2>
    <form method="POST" action="">
        <label for="firstname">First Name:</label><br>
        <input type="text" id="firstname" name="firstname" required><br><br>
        <label for="lastname">Last Name:</label><br>
        <input type="text" id="lastname" name="lastname" required><br><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>
