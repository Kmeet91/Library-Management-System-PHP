<?php
require_once "config.php";

// Function to create the borrowed_books table if needed
function checkAndCreateTable()
{
    global $link;
    // Check if borrowed_books table exists
    $check_borrowed_sql = "SHOW TABLES LIKE 'borrowed_books'";
    $borrowed_result = mysqli_query($link, $check_borrowed_sql);
    $borrowed_table_exists = mysqli_num_rows($borrowed_result) > 0;

    // Check if returned_books table exists
    $check_returned_sql = "SHOW TABLES LIKE 'returned_books'";
    $returned_result = mysqli_query($link, $check_returned_sql);
    $returned_table_exists = mysqli_num_rows($returned_result) > 0;

    // If borrowed_books table does not exist, create it
    if (!$borrowed_table_exists) {
        $create_borrowed_sql = "CREATE TABLE borrowed_books (
                book_id INT NOT NULL,
                title VARCHAR(255) NOT NULL,
                author VARCHAR(255) NOT NULL,
                borrowed_date DATE NOT NULL,
                return_date DATE NOT NULL
            )";
        if (mysqli_query($link, $create_borrowed_sql)) {
            // echo "Table borrowed_books created successfully";
        } else {
            echo "Error creating table: " . mysqli_error($link);
        }
    }

    // If returned_books table does not exist, create it
    if (!$returned_table_exists) {
        $create_returned_sql = "CREATE TABLE returned_books (
                book_id INT NOT NULL,
                title VARCHAR(255) NOT NULL,
                author VARCHAR(255) NOT NULL,
                borrowed_date DATE NOT NULL,
                return_date DATE NOT NULL
            )";
        if (mysqli_query($link, $create_returned_sql)) {
            // echo "Table returned_books created successfully";
        } else {
            echo "Error creating table: " . mysqli_error($link);
        }
    }
}

// Function to search for books
function searchBooks($searchTerm)
{
    global $link;
    $searchTerm = mysqli_real_escape_string($link, $searchTerm);
    $sql = "SELECT book_id, title, author, genre, publication_year, price, language, quantity FROM books WHERE title LIKE '%$searchTerm%' OR author LIKE '%$searchTerm%'";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        die("Error: " . mysqli_error($link));
    }
    $books = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    return $books;
}

checkAndCreateTable();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
    $searchTerm = $_POST["search"];
    $books = searchBooks($searchTerm);
} else {
    $books = [];
}

// Initialize messages array
$messages = [];

// Handle adding books to borrowed_books table
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_to_borrowed_books"])) {

    $book_id = $_POST["book_id"];
    $title = $_POST["title"];
    $author = $_POST["author"];

        // Calculate borrowed and return dates
        $borrowed_date = date('Y-m-d');
        $return_date = date('Y-m-d', strtotime($borrowed_date . ' + 20 days'));

        // Insert book into borrowed_books table
        $insert_borrowed_sql = "INSERT INTO borrowed_books (book_id, title, author, borrowed_date, return_date) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($link, $insert_borrowed_sql);
        mysqli_stmt_bind_param($stmt, "issss", $book_id, $title, $author, $borrowed_date, $return_date);
        if (mysqli_stmt_execute($stmt)) {
            $messages[] = "Book added successfully";

            // Decrease book quantity in books table
            $update_quantity_sql = "UPDATE books SET quantity = quantity - 1 WHERE book_id = ?";
            $stmt_quantity = mysqli_prepare($link, $update_quantity_sql);
            mysqli_stmt_bind_param($stmt_quantity, "i", $book_id);
            mysqli_stmt_execute($stmt_quantity);

            // Close statements
            mysqli_stmt_close($stmt_quantity);
        } else {
            $messages[] = "Error adding book '$title' by '$author' to borrowed_books: " . mysqli_error($link);
        }
        // Close statement
        mysqli_stmt_close($stmt);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Books</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!--for icon with navbar -->
    <link rel="stylesheet" href="search_css.css">
</head>

<body>
    <ul>
        <li><a href="library_books.php"><i class="fa fa-fw fa-home"></i>Home</a></li>
        <li><a class="active" href="search_books.php"><i class="fa fa-fw fa-search"></i>Search Books</a></li>
        <li><a href="borrowed_books.php"><i class="fa fa-fw fa-book"></i>Borrowed Books</a></li>
        <li><a href="return_books.php"><i class="fa fa-fw fa-reply"></i>Return Books</a></li>
        <li><a href="feedback.php" class="dropbtn"><i class="fa fa-fw fa-commenting"></i>Feedback</a></li>
        <li><a href="contact_me.php" title="If you have any query you can ask us"><i class="fa fa-fw fa-envelope"></i>Contact Us</a></li>
        <li style="float:right"><a href="login.php"><i class="fa fa-fw fa-user"></i>Login</a></li>
    </ul>
    <div class="search">
        <br><br>
        <form method="post" action="search_books.php">
            <label for="search">Search:</label>
            <input type="text" name="search" id="search">
            <button type="submit">Search</button>
        </form>
    </div>

    <?php if (!empty($books)) : ?>
        <h2>Search Results:</h2>
        <table>
            <thead>
                <tr>
                    <th>Book id</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Genre</th>
                    <th>Publication Year</th>
                    <th>Price</th>
                    <th>Language</th>
                    <th>Quantity</th>
                    <th>Add</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book) : ?>
                    <tr>
                        <td><?php echo $book['book_id']; ?></td>
                        <td><?php echo $book['title']; ?></td>
                        <td><?php echo $book['author']; ?></td>
                        <td><?php echo $book['genre']; ?></td>
                        <td><?php echo $book['publication_year']; ?></td>
                        <td><?php echo $book['price']; ?></td>
                        <td><?php echo $book['language']; ?></td>
                        <td><?php echo $book['quantity']; ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
                                <input type="hidden" name="title" value="<?php echo $book['title']; ?>">
                                <input type="hidden" name="author" value="<?php echo $book['author']; ?>">
                                <!-- <input type="number" name="quantity" value="1" min="1"> Add input for quantity -->
                                <button type="submit" name="add_to_borrowed_books">Add</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <?php if (!empty($messages)) : ?>
        <ul>
            <?php foreach ($messages as $message) : ?>
                <li class="message"><?php echo $message; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <hr>
    <footer>
        <?php
        if (isset($_COOKIE['last_visited_page'])) {
            $lastVisitedPage = $_COOKIE['last_visited_page'];
            echo "Last visited page: " . $lastVisitedPage;
        }
        ?>
        <p style="text-align: center;">&copy; 2024. All rights reserved.</p>

        <a href="library_books.php"><button style="float: left;"><i class="fa fa-fw fa-arrow-left"></i>Previous</button></a>
        <a href="borrowed_books.php"><button style="float: right;">Next<i class="fa fa-fw fa-arrow-right"></i></button></a>
    </footer>
</body>

</html>