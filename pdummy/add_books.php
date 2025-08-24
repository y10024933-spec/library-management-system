<?php
include('db.php');

// Add Book
if (isset($_POST['addBook'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];

    $sql = "INSERT INTO books (title, author, year) VALUES ('$title', '$author', '$year')";
    if ($conn->query($sql) === TRUE) {
        echo "";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Delete Book
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM books WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "";
    } else {
        echo "Error: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management Dashboard</title>
    <link rel="stylesheet" href="syle.css">
    <style>
        /* Basic reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body */
body {
    font-family: Arial, sans-serif;
    background-image: url('SIMPLE.jpg'); /* Add your background image path */
    background-size: cover;
    background-position: center;
    color: white;
    padding: 20px;

  
}

/* Header */
h1 {
    text-align: center;
    font-size: 36px;
    margin-bottom: 20px;
}

/* Form */
form {
    background-color: rgba(0, 0, 0, 0.6); /* Semi-transparent background for form */
    padding: 20px;
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 10px;
    max-width: 400px;
    margin: 0 auto;
    margin-bottom: 30px;
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
}

/* Form Labels */
form label {
    display: block;
    margin-bottom: 8px;
    font-size: 16px;
}

/* Form Inputs */
form input[type="text"], form input[type="number"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 16px;
}

/* Submit Button */
form input[type="submit"] {
    background-color: #8B4513; /* Brown background */
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}

form input[type="submit"]:hover {
    background-color: #8B4513; /* Darker brown on hover */
}

/* Table */
table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
}

table th, table td {
    padding: 12px;
    text-align: left;
    border: 1px solid #ddd;
}

table th {
    background-color: brown; /* Brown background */
    color: white;
}

table td {
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black background for rows */
}

table a {
    color:#8B4513;
    text-decoration: none;
    font-weight: bold;
}

table a:hover {
    color:#3498db; /* Darker brown on hover */
}

/* Centering and layout adjustments */
h2 {
    text-align: center;
    margin-bottom: 20px;
}

    </style>
</head>

<body>
    <h1>Library Management Dashboard</h1>

    <!-- Add Book Form -->
    <h2>Add New Book</h2>
    <form method="POST" action="">
        <label for="title">Title:</label>
        <input type="text" name="title" required>
        <br>
        <label for="author">Author:</label>
        <input type="text" name="author" required>
        <br>
        <label for="year">Year:</label>
        <input type="number" name="year" required>
        <br>
        <input type="submit" name="addBook" value="Add Book">
    </form>

    <hr>

    <!-- Book List -->
    <h2>Books List</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Year</th>
                
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM books");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['title'] . "</td>
                            <td>" . $row['author'] . "</td>
                            <td>" . $row['year'] . "</td>
                        
                            <td><a href='?delete=" . $row['id'] . "'>Delete</a></td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No books found</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>

<?php
$conn->close();
?>
