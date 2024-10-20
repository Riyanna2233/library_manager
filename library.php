<?php
   // Database connection parameters
   $hostname = "sql305.infinityfree.com";
   $username = "if0_37551939";
   $password = "JhdOgJOg6242";
   $database = "if0_37551939_lib123";
    // Establish database connection
    $connection = mysqli_connect($hostname, $username, $password, $database);

    // Check connection
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Insert new book if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_book'])) {
        $title = $_POST["title"];
        $author = $_POST["author"];
        $year_published = $_POST["year_published"];

        $sql = "INSERT INTO books (title, author, year_published) VALUES ('$title', '$author', '$year_published')";
        if (mysqli_query($connection, $sql)) {
            echo "New book added successfully!<br>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($connection);
        }
    }

    // Update book details if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_book'])) {
        $id = $_POST["id"];
        $title = $_POST["title"];
        $author = $_POST["author"];
        $year_published = $_POST["year_published"];

        $sql = "UPDATE books SET title='$title', author='$author', year_published='$year_published' WHERE id='$id'";
        if (mysqli_query($connection, $sql)) {
            echo "Book updated successfully!<br>";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
    }

    // Delete book if requested
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $sql = "DELETE FROM books WHERE id='$id'";
        if (mysqli_query($connection, $sql)) {
            echo "Book deleted successfully!<br>";
        } else {
            echo "Error deleting record: " . mysqli_error($connection);
        }
    }

    // Retrieve all books
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['view_books'])) {
        $sql = "SELECT * FROM books";
        $result = mysqli_query($connection, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<h3>List of Available Books:</h3>";
            echo "<table border='1'>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Year Published</th>
                        <th>Actions</th>
                    </tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["title"] . "</td>
                        <td>" . $row["author"] . "</td>
                        <td>" . $row["year_published"] . "</td>
                        <td>
                            <a href='library.php?delete=" . $row["id"] . "'>Delete</a>
                            <a href='?edit=" . $row["id"] . "'>Edit</a>
                        </td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "No books found!";
        }
    }

    // Retrieve book data for editing if requested
    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $sql = "SELECT * FROM books WHERE id='$id'";
        $result = mysqli_query($connection, $sql);
        $book = mysqli_fetch_assoc($result);
    }

    mysqli_close($connection);
?>
