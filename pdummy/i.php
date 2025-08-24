<?php
include('fetch_announcements.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Announcements</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        .announcement {
            background-color: #ffffff;
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .announcement h2 {
            margin-top: 0;
        }
        .announcement p {
            font-size: 16px;
        }
        .announcement small {
            display: block;
            margin-top: 10px;
            color: #888;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Library Announcements</h1>
    <?php foreach ($announcements as $announcement): ?>
        <div class="announcement">
            <h2><?php echo htmlspecialchars($announcement['title']); ?></h2>
            <p><?php echo nl2br(htmlspecialchars($announcement['content'])); ?></p>
            <small>Posted on <?php echo $announcement['created_at']; ?></small>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
