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

// Get the song ID from the URL
$song_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch song details from database
$sql = "SELECT title, album, year, artist, music_path, poster_url FROM songs WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $song_id);
$stmt->execute();
$result = $stmt->get_result();
$song = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($song['title']); ?> - Music Player</title>
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

        .music-details {
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
            text-align: center;
        }

        .music-item h2 {
            font-size: 24px;
            color: #333;
        }

        .music-item p {
            color: #666;
            font-size: 18px;
        }

        audio {
            width: 100%;
            margin-top: 15px;
            outline: none;
        }

        img {
            width: 200px;
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
        <h1><?php echo htmlspecialchars($song['title']); ?></h1>
    </header>

    <div class="music-details">
        <?php if ($song): ?>
            <div class="music-item">
                <h2><?php echo htmlspecialchars($song['title']); ?></h2>
                <p><?php echo htmlspecialchars($song['album']); ?> (<?php echo htmlspecialchars($song['year']); ?>) by <?php echo htmlspecialchars($song['artist']); ?></p>
                <audio controls>
                    <source src="<?php echo htmlspecialchars($song['music_path']); ?>" type="audio/mpeg">
                    Your browser does not support the audio tag.
                </audio>
                <img src="<?php echo htmlspecialchars($song['poster_url']); ?>" alt="Poster for <?php echo htmlspecialchars($song['title']); ?>">
            </div>
        <?php else: ?>
            <p>Song not found.</p>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Music Player. All rights reserved.</p>
    </footer>

    <?php 
    $stmt->close(); 
    $conn->close(); 
    ?>
</body>

</html>
