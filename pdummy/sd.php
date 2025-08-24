<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: rgb(37, 37, 41);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            background-color: #000;
            background-image: url('SIMPLE.jpg');
            overflow: hidden;
        }

        /* Header Styling */
        header {
            width: 100%;
            background-color: #333;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        /* Navigation Bar Styling */
        nav {
            width: 100%;
            background-color: #444;
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 10px 0;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            font-weight: bold;
        }

        nav a:hover {
            background-color: white;
            border-radius: 5px;
        }

        /* Container for Cards */
        .container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            width: 90%;
            max-width: 1000px;
            padding: 20px;
            margin-top: 50px;
        }

        /* Card Styling */
        .card {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            transition: transform 0.3s ease;
            backdrop-filter: blur(10px);
            color: #333;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .card img {
            width: 100px;
            height: 90px;
            margin-bottom: 15px;
        }

        .card h4 {
            margin: 10px 0;
            color: wheat;
        }

        .card p {
            font-size: 14px;
            margin-bottom: 15px;
            color: wheat;
        }

        .btn {
            padding: 10px 20px;
            background-color: #333;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #45a049;
        }

        /* Hover Effect */
        .card:hover {
            transform: translateY(-10px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            nav {
                flex-direction: column;
                align-items: center;
            }

            nav a {
                padding: 10px;
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>

    <header>
        <h1>Student Dashboard</h1>
    </header>

    <nav>
        <a href="profile.php">My Profile</a>
        <a href="courses.php">Browse Courses</a>
        <a href="grades.php">My Grades</a>
        <a href="contact.php">Contact</a>
    </nav>

    <div class="container">
        <!-- Profile Card -->
        <div class="card">
            <img src="s1r.png" alt="My Profile">
            <h4>My Profile</h4>
            <p>View and update your personal information.</p>
            <a href="profile.php" class="btn">View Profile</a>
        </div>

        <!-- Courses Card -->
        <div class="card">
            <img src="s2.jpg" alt="Browse Courses">
            <h4>Browse Courses</h4>
            <p>Explore available courses and enroll.</p>
            <a href="books.php" class="btn">Browse Courses</a>
        </div>

        <!-- Grades Card -->
        <div class="card">
            <img src="grades.jpg" alt="My Grades">
            <h4>Feedback</h4>
            <p>Check your academic performance.</p>
            <a href="sdf.php" class="btn">View Grades</a>
        </div>

        <!-- Notifications Card -->
        <div class="card">
            <img src="notifications.jpg" alt="Notifications">
            <h4>Notifications</h4>
            <p>Stay updated with the latest announcements.</p>
            <a href="student_announcements.php" class="btn">View Notifications</a>
        </div>
    </div>

</body>
</html>
