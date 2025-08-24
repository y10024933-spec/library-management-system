<?php
session_start();

// ڈیٹا بیس کنکشن کی تفصیلات
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school_db"; // یہاں اپنی ڈیٹا بیس کا نام درج کریں

// ڈیٹا بیس سے کنکشن قائم کریں
$conn = new mysqli($servername, $username, $password, $dbname);

// کنکشن کی جانچ کریں
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// اگر طالب علم لاگ ان ہے تو اس کی معلومات حاصل کریں
if (isset($_SESSION['student_id'])) {
    $student_id = $_SESSION['student_id'];

    // طالب علم کی معلومات حاصل کرنے کے لیے SQL کوئری
    $sql = "SELECT student_name, email, mobile FROM students WHERE student_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($student_name, $email, $mobile);

    if ($stmt->fetch()) {
        // طالب علم کی معلومات دستیاب ہیں
    } else {
        // طالب علم کی معلومات نہیں مل سکیں
        echo "Student not found.";
        exit();
    }
    $stmt->close();
} else {
    // اگر طالب علم لاگ ان نہیں ہے تو لاگ ان پیج پر ری ڈائریکٹ کریں
    header("Location: student_login.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .profile-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        .profile-container h2 {
            margin-bottom: 10px;
        }
        .profile-container p {
            margin: 5px 0;
        }
        .profile-container a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .profile-container a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <h2><?php echo htmlspecialchars($student_name); ?></h2>
    <p>Email: <?php echo htmlspecialchars($email); ?></p>
    <p>Mobile: <?php echo htmlspecialchars($mobile); ?></p>
    <a href="edit_student_profile.php">Edit Profile</a>
</div>

</body>
</html>
