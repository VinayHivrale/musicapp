<?php
// Database configuration
$servername = "database-2.c5k4ul5ztjqm.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "vinay2608"; // Replace with your actual password
$dbname = "musicapp";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch songs from database
$sql = "SELECT id, title FROM songs";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Player</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        h1 {
            margin: 0;
            font-size: 2.5em;
            letter-spacing: 1px;
        }

        .music-list {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .music-item {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            margin: 15px 0;
            width: 90%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s;
            text-align: center;
        }

        .music-item:hover {
            transform: scale(1.02);
        }

        .music-item a {
            text-decoration: none;
            color: #333;
            font-size: 20px;
        }

        footer {
            text-align: center;
            padding: 10px 0;
            background: #333;
            color: #fff;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>

<body>
    <header>
        <h1>Music Player</h1>
    </header>

    <div class="music-list">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="music-item">
                    <a href="song.php?id=<?php echo htmlspecialchars($row['id']); ?>">
                        <?php echo htmlspecialchars($row['title']); ?>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No songs found.</p>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Music Player. All rights reserved.</p>
    </footer>

    <?php $conn->close(); ?>
</body>

</html>
