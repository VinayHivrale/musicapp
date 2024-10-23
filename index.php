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
$sql = "SELECT title, album, year, artist, music_path, poster_url FROM songs";
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
        }

        .music-item:hover {
            transform: scale(1.02);
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
            margin-top: 15px;
            outline: none;
        }

        img {
            width: 100px;
            margin-top: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
                    <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                    <p><?php echo htmlspecialchars($row['album']); ?> (<?php echo htmlspecialchars($row['year']); ?>) by <?php echo htmlspecialchars($row['artist']); ?></p>
                    <audio controls>
                        <source src="<?php echo htmlspecialchars($row['music_path']); ?>" type="audio/mpeg">
                        Your browser does not support the audio tag.
                    </audio>
                    <img src="<?php echo htmlspecialchars($row['poster_url']); ?>" alt="Poster for <?php echo htmlspecialchars($row['title']); ?>">
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
