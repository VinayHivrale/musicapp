<?php
// Database configuration
$servername = "database-1.c5k4ul5ztjqm.us-east-1.rds.amazonaws.com";
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
$sql = "SELECT title, album, year, artist, music_path FROM songs";
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
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .music-list {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .music-item {
            background: white;
            border-radius: 5px;
            padding: 15px;
            margin: 10px;
            width: 90%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .music-item h2 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .music-item p {
            margin: 5px 0;
            color: #666;
        }

        audio {
            width: 100%;
            margin-top: 10px;
        }

        img {
            width: 100px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <h1>Music Player</h1>

    <div class="music-list">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="music-item">
                    <h2><?php echo $row['title']; ?></h2>
                    <p><?php echo $row['album']; ?> (<?php echo $row['year']; ?>) by <?php echo $row['artist']; ?></p>
                    <audio controls>
                        <source src="<?php echo $row['music_path']; ?>" type="audio/mpeg">
                        Your browser does not support the audio tag.
                    </audio>
                    <img src="./assets/images/poster-placeholder.jpg" alt="Poster" width="100"> <!-- Placeholder for poster -->
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No songs found.</p>
        <?php endif; ?>
    </div>

    <?php $conn->close(); ?>
</body>

</html>
