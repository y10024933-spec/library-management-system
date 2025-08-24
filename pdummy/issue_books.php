<?php
include('db.php');

// Issue Book
if (isset($_POST['issueBook'])) {
    $student_name = $_POST['student_name'];
    $book_id = $_POST['book_id'];
    $issue_date = $_POST['issue_date'];

    $sql = "INSERT INTO issued_books (student_name, book_id, issue_date) VALUES ('$student_name', '$book_id', '$issue_date')";
    if ($conn->query($sql) === TRUE) {
        echo "Book issued successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Books</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Add your styles here */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-image: url('SIMPLE.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 20px;
        }

        h1 {
            text-align: center;
            font-size: 36px;
            margin-bottom: 20px;
        }

        form {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 10px;
            max-width: 400px;
            margin: 0 auto;
            margin-bottom: 30px;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
        }

        form input[type="text"], form input[type="date"], form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        form input[type="submit"] {
            background-color: #8B4513;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #8B4513;
        }

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
            background-color: brown;
            color: white;
        }

        table td {
            background-color: rgba(0, 0, 0, 0.5);
        }
    </style>
</head>

<body>
    <h1>Issue Book</h1>

    <h2>Issue Book to Student</h2>
    <form method="POST" action="">
        <label for="student_name">Student Name:</label>
        <input type="text" name="student_name" required>
        <br>

        <label for="book_id">Select Book:</label>
        <select name="book_id" required>
            <?php
            // Fetch books from the database to display in the dropdown
            $result = $conn->query("SELECT * FROM books");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['title'] . " by " . $row['author'] . "</option>";
                }
            }
            ?>
        </select>
        <br>

        <label for="issue_date">Issue Date:</label>
        <input type="date" name="issue_date" required>
        <br>

        <input type="submit" name="issueBook" value="Issue Book">
    </form>

    <hr>

    <!-- Issued Books List -->
    <h2>Issued Books List</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Student Name</th>
                <th>Book Title</th>
                <th>Issue Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT issued_books.id, issued_books.student_name, books.title, issued_books.issue_date
                                    FROM issued_books
                                    JOIN books ON issued_books.book_id = books.id");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['student_name'] . "</td>
                            <td>" . $row['title'] . "</td>
                            <td>" . $row['issue_date'] . "</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No books issued yet</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>
