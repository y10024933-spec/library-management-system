<?php
include('db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Books</title>
    <link rel="stylesheet" href="style.css">
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
            background-image: url('SIMPLE.jpg'); /* Background image */
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
            background-color: brown;
            color: white;
        }

        table td {
            background-color: rgba(0, 0, 0, 0.5);
        }

        table a {
            color:#8B4513;
            text-decoration: none;
            font-weight: bold;
        }

        table a:hover {
            color:#3498db;
        }

        /* Centering and layout adjustments */
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <h1>Browse Books</h1>

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
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetching all books from the database
            $result = $conn->query("SELECT * FROM books");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['title'] . "</td>
                            <td>" . $row['author'] . "</td>
                            <td>" . $row['year'] . "</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No books found</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>

<?php
$conn->close();
?>
