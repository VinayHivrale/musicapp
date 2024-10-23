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
            background-color: #121212;
            color: #ffffff;
            margin: 0;
            padding: 0;
        }

        header {
            background: #1f1f1f;
            color: #ffffff;
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
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .music-item {
            background: #1e1e1e;
            border-radius: 10px;
            padding: 20px;
            margin: 15px;
            width: 70%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
        }

        .music-item img {
            width: 200px;
            margin-right: 20px;
            border-radius: 10px;
        }

        .music-item h2 {
            font-size: 24px;
            color: #ffffff;
        }

        .music-item p {
            color: #cccccc;
            font-size: 18px;
        }

        audio {
            width: 100%;
            margin-top: 15px;
            outline: none;
            background: #1f1f1f;
            border: none;
        }

        footer {
            text-align: center;
            padding: 10px 0;
            background: #1f1f1f;
            color: #ffffff;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        .audio-control {
            background: #1f1f1f;
            border: none;
            color: #ffffff;
            border-radius: 5px;
            padding: 5px;
        }

        .audio-control::-webkit-media-controls-panel {
            background-color: #1f1f1f;
            color: #ffffff;
        }

        .audio-control::-webkit-media-controls-play-button {
            background: #1f1f1f;
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
                <img src="<?php echo htmlspecialchars($song['poster_url']); ?>" alt="Poster for <?php echo htmlspecialchars($song['title']); ?>">
                <div>
                    <h2><?php echo htmlspecialchars($song['title']); ?></h2>
                    <p><?php echo htmlspecialchars($song['album']); ?> (<?php echo htmlspecialchars($song['year']); ?>) by <?php echo htmlspecialchars($song['artist']); ?></p>
                    <audio class="audio-control" controls>
                        <source src="<?php echo htmlspecialchars($song['music_path']); ?>" type="audio/mpeg">
                        Your browser does not support the audio tag.
                    </audio>
                </div>
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
