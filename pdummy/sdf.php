<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "teacher_dashboard_db";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

$student_name = 'John Doe'; // Static student name

// Fetch Student Requests
$studentRequests = $conn->query("SELECT * FROM teacher_requests WHERE student_name = '$student_name'"); 

// Fetch Student Feedback
$studentFeedback = $conn->query("SELECT * FROM student_feedback WHERE student_name = '$student_name' ORDER BY date DESC LIMIT 3");

// Handle Request Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_request'])) {
    $request_title = mysqli_real_escape_string($conn, $_POST['request_title']);
    $request_type = mysqli_real_escape_string($conn, $_POST['request_type']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $insert_request = "INSERT INTO teacher_requests (student_name, request_title, request_type, message)
                        VALUES ('$student_name', '$request_title', '$request_type', '$message')";

    if ($conn->query($insert_request) === TRUE) {
        $success_msg = "✅ Request sent successfully!";
        $studentRequests = $conn->query("SELECT * FROM teacher_requests WHERE student_name = '$student_name'");
    } else {
        $error_msg = "❌ Error: " . $conn->error;
    }
}

// Handle Feedback Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_feedback'])) {
    $feedback = mysqli_real_escape_string($conn, $_POST['feedback']);

    $insert_feedback = "INSERT INTO student_feedback (student_name, feedback) VALUES ('$student_name', '$feedback')";
    if ($conn->query($insert_feedback) === TRUE) {
        $success_feedback_msg = "✅ Feedback submitted successfully!";
        $studentFeedback = $conn->query("SELECT * FROM student_feedback WHERE student_name = '$student_name' ORDER BY date DESC LIMIT 3");
    } else {
        $error_feedback_msg = "❌ Error: " . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>🎓 Student Dashboard</title>
    <style>
      body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f4f9; /* Light background color */
    background-image: url('SIMPLE.jpg'); /* Background image URL */
    background-size: cover; /* Ensure the background covers the entire screen */
    background-position: center center; /* Center the background image */
    background-attachment: fixed; /* Keep the background fixed while scrolling */
    margin: 0;
    padding: 20px;
    color: #333; /* Dark text for readability */
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 30px;
    background: rgba(255, 255, 255, 0.9); /* Slightly transparent white background */
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.25); /* Soft shadow for better contrast */
    backdrop-filter: blur(120px); /* Apply blur effect for a frosted-glass effect */
    -webkit-backdrop-filter: blur(120px); /* For Safari */
    border: 2px solid rgba(211, 175, 55, 0.9); /* Gold border with slight transparency */
}

h2, h3 {
    color: #fff; /* White text for headings */
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 15px;
    text-align: center;
}

.card {
    background: rgba(255, 244, 230, 0.9); /* Light brown with transparency */
    padding: 20px;
    margin: 15px 0;
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

form {
    display: flex;
    flex-direction: column;
    gap: 12px; /* Reduced gap between elements */
    background: rgba(255, 244, 230, 0.85); /* Light brown with transparency */
    padding: 15px; /* Reduced padding */
    border-radius: 10px; /* Slightly smaller border radius */
    border: 1px solid rgba(211, 175, 55, 0.9); /* Gold border with slight transparency */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */
    backdrop-filter: blur(12px); /* Apply blur effect for frosted-glass effect */
    -webkit-backdrop-filter: blur(12px); /* For Safari */
    max-width: 600px; /* Reduced max width */
    margin: 20px auto; /* Centered with smaller width */
}

form input[type="text"], 
form textarea, 
form select {
    padding: 10px; /* Reduced padding */
    font-size: 14px; /* Slightly smaller font size */
    border: 1px solid rgba(211, 175, 55, 0.7); /* Subtle golden border */
    border-radius: 6px; /* Slightly smaller border radius */
    width: 100%;
    box-sizing: border-box;
    background: rgba(255, 244, 230, 0.9); /* Light brown with transparency */
    color: #333; /* Dark text for readability */
    transition: border-color 0.3s ease;
}

form input[type="text"]:focus, 
form textarea:focus, 
form select:focus {
    outline: none;
    border-color: #D4AF37; /* Gold border when focused */
}

button {
    background: #8B4513; /* Rich brown for the button */
    color: white;
    padding: 12px 24px; /* Reduced padding */
    border: none;
    border-radius: 6px; /* Smaller radius */
    cursor: pointer;
    font-size: 16px; /* Slightly smaller font size */
    transition: background 0.3s ease;
    margin-top: 10px; /* Space between button and input fields */
}

button:hover {
    background: #6A2E1F; /* Darker brown when hovered */
}

/* Optional: Style for success/error messages inside the form */
form .success, 
form .error {
    padding: 10px;
    border-radius: 6px;
    font-size: 14px; /* Smaller font size */
    font-weight: bold;
    margin-top: 12px; /* Reduced margin */
}

form .success {
    background-color: rgba(231, 247, 231, 0.9); /* Very light green */
    color: #155724;
    border-left: 5px solid #28a745; /* Green left border */
}

form .error {
    background-color: rgba(248, 215, 218, 0.9); /* Soft pink */
    color: #721c24;
    border-left: 5px solid #f44336; /* Red left border */
}

    </style>
</head>
<body>

<div class="container">
    <h2>🎓 Student Dashboard - <?php echo $student_name; ?></h2>

    <!-- Request Submission Form -->
    <div class="card">
        <h3>📤 Submit a Request</h3>
        <?php if (isset($success_msg)) echo "<div class='message success'>$success_msg</div>"; ?>
        <?php if (isset($error_msg)) echo "<div class='message error'>$error_msg</div>"; ?>
        
        <form method="POST" action="">
            <input type="text" name="request_title" placeholder="Request Title" required>
            <select name="request_type" required>
                <option value="Normal">Normal Request</option>
                <option value="Urgent">Urgent Request</option>
            </select>
            <textarea name="message" rows="4" placeholder="Describe your request..." required></textarea>
            <button type="submit" name="submit_request">Send Request</button>
        </form>
    </div>

    <!-- Recent Requests -->
    <div class="card">
        <h3>📥 My Requests</h3>
        <?php if ($studentRequests->num_rows > 0): ?>
            <?php while ($request = $studentRequests->fetch_assoc()): ?>
                <p><strong><?php echo $request['request_title']; ?></strong> 
                <span class="request-status">[Status: <?php echo $request['status']; ?>]</span></p>
                <p><?php echo $request['message']; ?></p>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No requests submitted yet.</p>
        <?php endif; ?>
    </div>

    <!-- Feedback Submission Form -->
    <div class="card">
        <h3>📝 Submit Feedback</h3>
        <?php if (isset($success_feedback_msg)) echo "<div class='message success'>$success_feedback_msg</div>"; ?>
        <?php if (isset($error_feedback_msg)) echo "<div class='message error'>$error_feedback_msg</div>"; ?>
        
        <form method="POST" action="">
            <textarea name="feedback" rows="4" placeholder="Write your feedback here..." required></textarea>
            <button type="submit" name="submit_feedback">Submit Feedback</button>
        </form>
    </div>

    <!-- Recent Feedback -->
    <div class="card">
        <h3>⭐ My Feedback</h3>
        <?php if ($studentFeedback->num_rows > 0): ?>
            <?php while ($feedback = $studentFeedback->fetch_assoc()): ?>
                <p>"<?php echo $feedback['feedback']; ?>" 
                <span class="feedback-status">[Status: <?php echo $feedback['status'] ?? 'Pending'; ?>]</span></p>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No feedback submitted yet.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
