<?php
session_start();
include('db.php');

// Initialize variables
$message = '';
$announcements = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);

    $sql = "INSERT INTO announcements (title, content) VALUES ('$title', '$content')";

    if ($conn->query($sql) === TRUE) {
        $message = "New announcement added successfully!";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle deletion
if (isset($_GET['delete_id'])) {
    $delete_id = (int) $_GET['delete_id'];
    $delete_sql = "DELETE FROM announcements WHERE id = $delete_id";

    if ($conn->query($delete_sql) === TRUE) {
        $message = "Announcement deleted successfully!";
    } else {
        $message = "Error deleting announcement: " . $conn->error;
    }
}

// Fetch announcements
$sql = "SELECT * FROM announcements ORDER BY created_at DESC";
$result = $conn->query($sql);

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
    <title>Manage Announcements</title>
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
            width: 50%;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #f4f4f9;
        }
        h2{
            color: #f4f4f9;
        }
        .form-group {
            margin-bottom: 15px;
            color: #f4f4f9;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            margin-top: 20px;
            font-size: 16px;
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
        .delete-link {
            color: red;
            text-decoration: none;
            font-size: 14px;
        }
        .delete-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Add New Announcement</h1>
    <?php if (!empty($message)) { echo "<div class='message'>$message</div>"; } ?>
    <form method="post" action="">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="content">Content:</label>
            <textarea id="content" name="content" rows="5" required></textarea>
        </div>
        <button type="submit">Add Announcement</button>
    </form>

    <h2>Recent Announcements</h2>
    <?php if (!empty($announcements)) {
        foreach ($announcements as $announcement) { ?>
            <div class="announcement">
                <h3><?php echo htmlspecialchars($announcement['title']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($announcement['content'])); ?></p>
                <small>Posted on <?php echo $announcement['created_at']; ?></small>
                <br>
                <a href="?delete_id=<?php echo $announcement['id']; ?>" class="delete-link" onclick="return confirm('Are you sure you want to delete this announcement?');">Delete</a>
            </div>
        <?php }
    } else {
        echo "<p>No announcements available.</p>";
    } ?>
</div>

</body>
</html>
