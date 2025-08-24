<?php
session_start();
include('db.php');

// Fetch announcements
$sql = "SELECT * FROM announcements ORDER BY created_at DESC";
$result = $conn->query($sql);

$announcements = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $announcements[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Announcements</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            background-image: url('SIMPLE.jpg');
            background-size: cover;
            background-position: center center;
        }
        .container {
            width: 70%;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #f4f4f9;
            text-align: center;
        }
        .announcement {
            background-color: #fff;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
        }
        .announcement h3 {
            margin-top: 0;
        }
        .announcement p {
            font-size: 16px;
        }
        .announcement small {
            display: block;
            margin-top: 10px;
            color: #777;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Student Announcements</h1>
    <?php if (!empty($announcements)) {
        foreach ($announcements as $announcement) { ?>
            <div class="announcement">
                <h3><?php echo htmlspecialchars($announcement['title']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($announcement['content'])); ?></p>
                <small>Posted on <?php echo $announcement['created_at']; ?></small>
            </div>
        <?php }
    } else {
        echo "<p>No announcements available at the moment.</p>";
    } ?>
</div>

</body>
</html>
