<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection
$host = 'localhost';
$db_name = 'school_db';
$db_user = 'root';  // Change if you have a different username
$db_pass = '';      // Enter your password if needed

// Connect to the database
$conn = new mysqli($host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login or registration logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $role = $_POST['role'];  // Role will be 'student' or 'teacher'
        $action = $_POST['action']; // 'login' or 'register'

        // Determine the table based on the role
        $table = ($role === 'student') ? 'students' : 'teachers';

        // Handle Login
        if ($action === 'login') {
            // Query to check if the username exists for the given role
            $query = "SELECT * FROM $table WHERE username = ?";
            $stmt = $conn->prepare($query);

            if ($stmt) {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // User found, verify password
                    $user = $result->fetch_assoc();
                    if (password_verify($password, $user['password'])) {
                        // Password is correct, start session and redirect
                        session_start();
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['role'] = $role;

                        // Redirect to the appropriate dashboard based on role
                        if ($role === 'student') {
                            header('Location: sd.php');  // Redirect to student dashboard
                            exit();
                        } elseif ($role === 'teacher') {
                            header('Location: td.php');  // Redirect to teacher dashboard
                            exit();
                        }
                    } else {
                        echo "Invalid password. Please try again.<br>";
                    }
                } else {
                    echo "User not found. Please check your username.<br>";
                }

                $stmt->close();
            } else {
                echo "Error preparing the statement.<br>";
            }
        } elseif ($action === 'register') {
            // Handle Registration
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO $table (username, password) VALUES (?, ?)";
            $stmt = $conn->prepare($query);

            if ($stmt) {
                $stmt->bind_param("ss", $username, $hashed_password);

                if ($stmt->execute()) {
                    echo "Registration successful!<br>";
                } else {
                    echo "Error: " . $stmt->error . "<br>";
                }

                $stmt->close();
            } else {
                echo "Error preparing the statement.<br>";
            }
        }
    } else {
        echo "Action not set. Please try again.<br>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login or Register</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@200;300;400;500;600;700&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Open Sans", sans-serif;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            width: 100%;
            padding: 0 10px;
            background: url("SIMPLE.jpg") center center no-repeat;
            background-size: cover;
        }

        .wrapper {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 8px;
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #fff;
        }

        .input-field {
            position: relative;
            border-bottom: 2px solid #ccc;
            margin: 15px 0;
        }

        .input-field label {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            color: #fff;
            font-size: 16px;
            pointer-events: none;
            transition: 0.15s ease;
        }

        .input-field input {
            width: 100%;
            height: 40px;
            background: transparent;
            border: none;
            outline: none;
            font-size: 16px;
            color: #fff;
        }

        .input-field input:focus ~ label,
        .input-field input:valid ~ label {
            font-size: 0.8rem;
            top: 10px;
            transform: translateY(-120%);
        }

        /* .select-field {
            margin: 15px 0;
        } */
        .select-field {
    margin: 15px 0;
    background-color:rgb(27, 15, 15); /* Ashy gray color */
    border: 1px solid #888;    /* Light border for the field */
    border-radius: 5px;        /* Rounded corners for the select box */
    padding: 10px;             /* Padding inside the select box */
    font-size: 16px;           /* Set font size */
    color: white;              /* Text color (assuming you want white text on gray) */
}

.select-field option {
    background-color: #333; /* Dark background for options */
    color: white; 
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);          /* White text for options */
}

        .forget {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 25px 0 35px 0;
            color: #fff;
        }

        #remember {
            accent-color: #fff;
        }

        .forget label {
            display: flex;
            align-items: center;
        }

        .forget label p {
            margin-left: 8px;
        }

        button {
            background: #fff;
            color: #000;
            font-weight: 600;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            border-radius: 3px;
            font-size: 16px;
            border: 2px solid transparent;
            transition: 0.3s ease;
        }

        button:hover {
            color: #fff;
            border-color: #fff;
            background: rgba(255, 255, 255, 0.15);
        }

        .register {
            text-align: center;
            margin-top: 30px;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="wrapper">
    <h2>Login</h2>
    <form action="login.php" method="post">
        <div class="input-field">
            <input type="text" name="username" id="username" required>
            <label>Enter your Name</label>
        </div>
        <div class="input-field">
            <input type="password" name="password" id="password" required>
            <label>Enter your Password</label>
        </div>

        <div class="select-field">
            <label for="role" style="color: white;">Role:</label>
            <select name="role" id="role" required>
                <option value="student">Student</option>
                <option value="teacher">Teacher</option>
            </select>
        </div>

        <div class="forget">
            <label for="remember">
                <input type="checkbox" id="remember">
                <p>Remember me</p>
            </label>
            <a href="#">Forgot password?</a>
        </div>

        <input type="hidden" name="action" value="login"> <!-- Hidden field for login action -->
        <button type="submit">Log In</button>
    </form>
</div>

</body>
</html>
