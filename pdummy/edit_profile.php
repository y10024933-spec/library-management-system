<?php
session_start();
include('db.php');

// Check if the user is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Fetch student details from the database
$sql = "SELECT student_ID, student_name, email, mobile FROM students WHERE student_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the student exists
if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
} else {
    echo "No student found.";
    exit();
}

// Update profile information
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_name = $conn->real_escape_string($_POST['student_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $mobile = $conn->real_escape_string($_POST['mobile']);

    $update_sql = "UPDATE students SET student_name = ?, email = ?, mobile = ? WHERE student_ID = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssi", $student_name, $email, $mobile, $student_id);

    if ($stmt->execute()) {
        $message = "Profile updated successfully!";
        // Refresh the student data
        $student['student_name'] = $student_name;
        $student['email'] = $email;
        $student['mobile'] = $mobile;
    } else {
        $message = "Error updating profile: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .container {
            width: 50%;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px;
        }
