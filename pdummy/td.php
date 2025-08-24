<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Dashboard</title>
    
    
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color:rgb(37, 37, 41);
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
            max-width: 1000px; /* Reduced width */
            padding: 20px;
            margin-top: 20px;
        }

        /* Card Styling */
        .card {
    background-color: rgba(255, 255, 255, 0.2); /* Semi-transparent white background */
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    transition: transform 0.3s ease;
    backdrop-filter: blur(10px); /* Apply blur effect to the background */
    color: #333; /* Dark text color for contrast */
    border: 1px solid rgba(255, 255, 255, 0.3); /* Optional: Light border for better visibility */
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
        <h1>Library Dashboard</h1>
    </header>

    <nav>
        <a href="add_books.php">Add Books</a>
        <a href="issue_books.php">Issue Books</a>
        <a href="return_books.php">Return Books</a>
        <a href="#">Contact</a>
    </nav>

    <div class="container">
        <!-- First Row: 3 Cards -->
        <div class="card">
            <img src="img1.avif" alt="Add Book">
            <h4>Add Book</h4>
            <p>Insert a new book into the library system.</p>
            <a href="add_books.php" class="btn">Add Book</a>
        </div>

        <div class="card">
            <img src="img2r.png" alt="Issue Book">
            <h4>Issue Book</h4>
            <p>Issue a book to a user.</p>
            <a href="issue_books.php" class="btn">Issue Book</a>
        </div>

        <div class="card">
            <img src="img3r.png" alt="Return Book">
            <h4>Return Book</h4>
            <p>Return a borrowed book to the library.</p>
            <a href="return_books.php" class="btn">Return Book</a>
        </div>

        <!-- Second Row: 2 Cards -->
        <div class="card">
            <img src="sf2.jpeg" alt="Student Feedback">
            <h4>Student Feedback</h4>
            <p>Provide feedback about the library services.</p>
            <a href="studentf.php" class="btn">Give Feedback</a>
        </div>

        <div class="card">
            <img src="img4.jpg" alt="Library Services">
            <h4>Library Services</h4>
            <p>Explore library services and resources.</p>
            <a href="add_announcement.php" class="btn">Learn More</a>
        </div>
    </div>

</body>
</html>
