<?php
include "config.php";

// Set last visited page cookie
setLastVisitedPageCookie('Return Books');

// Function to get returned books
function getReturnedBooks()
{
    global $link;
    $sql = "SELECT * FROM borrowed_books WHERE return_date IS NOT NULL"; // Select books with returned date not null
    $result = mysqli_query($link, $sql);
    if (!$result) {
        die("Error: " . mysqli_error($link));
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Function to move book from borrowed_books to returned_books and store the returned date
function moveBookToReturned($book_id)
{
    global $link;
    $returned_date = date('Y-m-d');
    $sql_select = "SELECT * FROM borrowed_books WHERE book_id = $book_id";
    $result = mysqli_query($link, $sql_select);
    if (!$result) {
        die("Error: " . mysqli_error($link));
    }
    $book = mysqli_fetch_assoc($result);
    if ($book) {
        $title = mysqli_real_escape_string($link, $book['title']);
        $author = mysqli_real_escape_string($link, $book['author']);
        $borrowed_date = $book['borrowed_date'];

        // Check if the book already exists in returned_books
        $check_sql = "SELECT * FROM returned_books WHERE book_id = $book_id";
        $check_result = mysqli_query($link, $check_sql);
        if (!$check_result) {
            die("Error: " . mysqli_error($link));
        }
        if (mysqli_num_rows($check_result) == 0) {
            // Insert the book into returned_books if it doesn't exist
            $sql_insert = "INSERT INTO returned_books (book_id, title, author, borrowed_date, return_date) VALUES ($book_id, '$title', '$author', '$borrowed_date', '$returned_date')";
            $result_insert = mysqli_query($link, $sql_insert);
            if (!$result_insert) {
                die("Error: " . mysqli_error($link));
            }
        }

        // Delete the book from borrowed_books
        $sql_delete = "DELETE FROM borrowed_books WHERE book_id = $book_id";
        $result_delete = mysqli_query($link, $sql_delete);
        if (!$result_delete) {
            die("Error: " . mysqli_error($link));
        }

        // Increase the quantity of the book
        $sql_update_quantity = "UPDATE books SET quantity = quantity + 1 WHERE book_id = $book_id";
        $result_update_quantity = mysqli_query($link, $sql_update_quantity);
        if (!$result_update_quantity) {
            die("Error: " . mysqli_error($link));
        }
    }
}


// Handle REMOVE or RENEW button click
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["remove_book"])) {
        $book_id = $_POST["book_id"];
        moveBookToReturned($book_id);
    } elseif (isset($_POST["renew_book"])) {
        $book_id = $_POST["book_id"];
        $current_date = date('Y-m-d'); // Get the current date
        $renewed_date = date('Y-m-d', strtotime($current_date . ' + 20 days')); // Calculate renewed date (current date + 20 days)

        // Update borrowed date and return date for the book
        $sql_update = "UPDATE borrowed_books SET borrowed_date = '$current_date', return_date = '$renewed_date' WHERE book_id = $book_id";
        $result_update = mysqli_query($link, $sql_update);
        if (!$result_update) {
            die("Error: " . mysqli_error($link));
        }
    }
}

// Get returned books
$returnedBooks = getReturnedBooks();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Returned Books</title>
    <link rel="stylesheet" href="return_css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!--for icon with navbar -->
</head>

<body>

    <ul>
        <li><a href="library_books.php"><i class="fa fa-fw fa-home"></i>Home</a></li>
        <li><a href="search_books.php"><i class="fa fa-fw fa-search"></i>Search Books</a></li>
        <li><a href="borrowed_books.php"><i class="fa fa-fw fa-book"></i>Borrowed Books</a></li>
        <li><a class="active" href="return_books.php"><i class="fa fa-fw fa-reply"></i>Return Books</a></li>
        <li><a href="feedback.php" class="dropbtn"><i class="fa fa-fw fa-commenting"></i>Feedback</a></li>
        <li><a href="contact_me.php" title="If you have any query you can ask us"><i class="fa fa-fw fa-envelope"></i>Contact Us</a></li>
        <li style="float:right"><a href="login.php"><i class="fa fa-fw fa-user"></i>Login</a></li>
    </ul>
    <h1>Return Books</h1>
    <?php if (empty($returnedBooks)) : ?>
        <p>No returned books found.</p>
    <?php else : ?>
        <h2>List of Returned Books</h2>
        <form method="post">
            <table>
                <thead>
                    <tr>
                        <th>Book id</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Borrowed Date</th>
                        <th>Return Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($returnedBooks as $book) : ?>
                        <tr>
                            <td><?php echo $book['book_id']; ?></td>
                            <td><?php echo $book['title']; ?></td>
                            <td><?php echo $book['author']; ?></td>
                            <td><?php echo $book['borrowed_date']; ?></td>
                            <td><?php echo $book['return_date']; ?></td>
                            <td>
                                <?php if ($book['return_date'] == date('Y-m-d')) : ?>
                                    <p>Book is returned</p>
                                <?php else : ?>
                                    <button type="submit" name="remove_book" value="remove_book">Remove</button>
                                    <button type="submit" name="renew_book" value="renew_book">Renew</button>
                                <?php endif; ?>
                                <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>
    <?php endif; ?>
    <hr>
    <footer>
        <?php
        require_once "config.php";
        if (isset($_COOKIE['last_visited_page'])) {
            $lastVisitedPage = $_COOKIE['last_visited_page'];
            echo "Last visited page: " . $lastVisitedPage;
        }
        ?>
        <p style="text-align: center;">&copy; 2024. All rights reserved.</p>
        <a href="borrowed_books.php"><button style="float: left;"><i class="fa fa-fw fa-arrow-left"></i>Previous</button></a>
        <a href="feedback.php"><button style="float: right;">Next<i class="fa fa-fw fa-arrow-right"></i></button></a>
    </footer>
</body>

</html>