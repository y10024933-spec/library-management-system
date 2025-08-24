<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "teacher_dashboard_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Pending Requests
$pendingRequests = $conn->query("SELECT * FROM teacher_requests WHERE status = 'Pending'");

// Fetch Recent Feedback
$recentFeedback = $conn->query("SELECT * FROM student_feedback ORDER BY date DESC LIMIT 3");

// Fetch Urgent Requests
$urgentRequests = $conn->query("SELECT * FROM teacher_requests WHERE request_type = 'Urgent'");

// Fetch Request Trends
$requestTrends = $conn->query("SELECT COUNT(*) as total_requests FROM teacher_requests");

// Handle Feedback Status Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $feedback_id = intval($_POST['feedback_id']);
    $action = $_POST['action'];

    if ($action == "Mark as Reviewed") {
        $update = $conn->query("UPDATE student_feedback SET status='Reviewed' WHERE id=$feedback_id");
        if (!$update) {
            echo "<p class='error'>Error: " . $conn->error . "</p>";
        }
    }
}

// Handle Request Approval/Rejection
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['request_action'])) {
    $request_id = intval($_POST['request_id']);
    $status = $_POST['request_action'];

    $update_request = $conn->query("UPDATE teacher_requests SET status='$status' WHERE id=$request_id");
    if (!$update_request) {
        echo "<p class='error'>Error: " . $conn->error . "</p>";
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>👩‍🏫 Teacher Dashboard</title>
    
    <style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9; /* Fallback color */
    background-image: url('SIMPLE.jpg'); /* Background image URL */
    background-size: cover; /* Make sure the image covers the whole screen */
    background-position: center center; /* Center the image */
    background-attachment: fixed; /* Keep the background fixed when scrolling */
    padding: 20px;
    color: #333; /* Dark text for readability */
}

.container {
    /* Slightly transparent white background */
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.25); /* Soft shadow for better contrast */
    backdrop-filter: blur(120px); /* Apply blur effect for a frosted-glass effect */
    -webkit-backdrop-filter: blur(120px); /* For Safari */
    border: 2px solid rgba(211, 175, 55, 0.9); /* Gold border with slight transparency */
    max-width: 1200px;
    margin: 0 auto;
}

h2 {
    color: white; /* Dark color for headings */
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 15px;
    text-align: center;
}

.card {
    padding: 20px;
    margin: 15px 0;
    background: rgba(255, 244, 230, 0.9); /* Light brown with transparency */
    border-left: 5px solid #D4AF37; /* Golden left border for cards */
    box-shadow: 0 3px 15px rgba(0, 0, 0, 0.2); /* Soft shadow for cards */
    border-radius: 8px;
    backdrop-filter: blur(8px); /* Apply blur effect to the background behind the card */
    -webkit-backdrop-filter: blur(8px); /* For Safari */
}


.card h3 {
    color: #3e3e3e; /* Dark text for card title */
    font-size: 24px;
    margin-bottom: 10px;
}

.urgent {
    background: rgba(253, 226, 226, 0.9); /* Light red background with transparency */
    border-left: 5px solid #f44336;
}

.actions button {
    padding: 12px 20px;
    background: #8B4513; /* Rich brown for action buttons */
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    transition: background 0.3s ease;
}

.actions button:hover {
    background: #6A2E1F; /* Darker brown when hovered */
}

button {
    background: #8B4513; /* Rich brown for primary button */
    color: white;
    padding: 14px 28px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 18px;
    transition: background 0.3s ease;
}

button:hover {
    background: #6A2E1F; /* Darker brown when hovered */
}

.message {
    padding: 15px;
    margin: 15px 0;
    border-radius: 8px;
    font-size: 16px;
    line-height: 1.6;
}

.success {
    background-color: rgba(231, 247, 231, 0.9); /* Very light green background */
    color: #155724;
    border-left: 5px solid #28a745; /* Green left border for success */
}

.error {
    background-color: rgba(248, 215, 218, 0.9); /* Soft pink background */
    color: #721c24;
    border-left: 5px solid #f44336; /* Red left border for errors */
}

footer {
    text-align: center;
    color: #8B4513; /* Dark brown footer text */
    margin-top: 30px;
}

footer a {
    color: #D4AF37; /* Golden link */
    text-decoration: none;
    font-weight: bold;
}

footer a:hover {
    color: #b28b00; /* Darker gold for hover effect */
}

         
    </style>
</head>
<body>

<div class="container">
    <h2>👩‍🏫 Teacher Dashboard</h2>

    <!-- Pending Requests -->
    <div class="card">
        <h3>📥 Pending Requests</h3>
        <?php while ($row = $pendingRequests->fetch_assoc()): ?>
            <p><strong><?php echo $row['request_title']; ?></strong> by <?php echo $row['student_name']; ?></p>
            <p>Message: <?php echo $row['message']; ?></p>
            <form method="POST" action="">
                <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                <button type="submit" name="request_action" value="Approved">Approve</button>
                <button type="submit" name="request_action" value="Rejected">Reject</button>
            </form>
        <?php endwhile; ?>
        <?php if ($pendingRequests->num_rows == 0) echo "<p>No pending requests.</p>"; ?>
    </div>

    <!-- Recent Feedback -->
    <div class="card">
        <h3>⭐ Recent Feedback</h3>
        <?php while ($feedback = $recentFeedback->fetch_assoc()): ?>
            <p><strong><?php echo $feedback['student_name']; ?></strong>: "<?php echo $feedback['feedback']; ?>"</p>
            <form method="POST" action="">
                <input type="hidden" name="feedback_id" value="<?php echo $feedback['id']; ?>">
                <button type="submit" name="action" value="Mark as Reviewed">Mark as Reviewed</button>
            </form>
        <?php endwhile; ?>
        <?php if ($recentFeedback->num_rows == 0) echo "<p>No recent feedback available.</p>"; ?>
    </div>

    <!-- Urgent Requests -->
    <div class="card urgent">
        <h3>🚩 Urgent Requests</h3>
        <?php while ($urgent = $urgentRequests->fetch_assoc()): ?>
            <p><strong><?php echo $urgent['request_title']; ?></strong> by <?php echo $urgent['student_name']; ?></p>
            <p>Message: <?php echo $urgent['message']; ?></p>
        <?php endwhile; ?>
        <?php if ($urgentRequests->num_rows == 0) echo "<p>No urgent requests.</p>"; ?>
    </div>

    <!-- Request Trends -->
    <div class="card">
        <h3>📊 Request Trends</h3>
        <?php
        $trend = $requestTrends->fetch_assoc();
        echo "<p>Total Requests: <strong>{$trend['total_requests']}</strong></p>";
        ?>
    </div>
</div>

</body>
</html>
