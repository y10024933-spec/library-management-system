<?php
include('db.php');

// Return Book
if (isset($_POST['returnBook'])) {
    $issued_book_id = $_POST['issued_book_id'];
    $return_date = $_POST['return_date'];

    // Update the issued book record with the return date
    $sql = "UPDATE issued_books SET return_date = '$return_date' WHERE id = $issued_book_id";
    if ($conn->query($sql) === TRUE) {
        echo "Book returned successfully!";
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
    <title>Return Books</title>
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

        form input[type="date"], form select {
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
    <h1>Return Book</h1>

    <h2>Return Issued Book</h2>
    <form method="POST" action="">
        <label for="issued_book_id">Select Issued Book:</label>
        <select name="issued_book_id" required>
            <?php
            // Fetch issued books from the database where return_date is NULL (books that haven't been returned yet)
            $result = $conn->query("SELECT issued_books.id, issued_books.student_name, books.title, issued_books.issue_date 
                                    FROM issued_books
                                    JOIN books ON issued_books.book_id = books.id
                                    WHERE issued_books.return_date IS NULL");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['title'] . " issued to " . $row['student_name'] . " on " . $row['issue_date'] . "</option>";
                }
            } else {
                echo "<option value=''>No books to return</option>";
            }
            ?>
        </select>
        <br>

        <label for="return_date">Return Date:</label>
        <input type="date" name="return_date" required>
        <br>

        <input type="submit" name="returnBook" value="Return Book">
    </form>

    <hr>

    <!-- Returned Books List -->
    <h2>Returned Books List</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Student Name</th>
                <th>Book Title</th>
                <th>Issue Date</th>
                <th>Return Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch all issued books along with their return dates
            $result = $conn->query("SELECT issued_books.id, issued_books.student_name, books.title, issued_books.issue_date, issued_books.return_date
                                    FROM issued_books
                                    JOIN books ON issued_books.book_id = books.id
                                    WHERE issued_books.return_date IS NOT NULL");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['student_name'] . "</td>
                            <td>" . $row['title'] . "</td>
                            <td>" . $row['issue_date'] . "</td>
                            <td>" . $row['return_date'] . "</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No books have been returned yet</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>
