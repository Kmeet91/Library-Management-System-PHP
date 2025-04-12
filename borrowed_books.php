<?php
include "config.php";

// Function to create the borrowed_books table if needed
function checkAndCreateTable()
{
    global $link;
    // Check if the borrowed_books table exists
    $check_table_sql = "SHOW TABLES LIKE 'borrowed_books'";
    $check_result = mysqli_query($link, $check_table_sql);
    if (mysqli_num_rows($check_result) == 0) {
        // Create the borrowed_books table
        $create_sql = "CREATE TABLE borrowed_books (
                        book_id INT,
                        title VARCHAR(255) NOT NULL,
                        author VARCHAR(255) NOT NULL,
                        borrowed_date DATE NOT NULL,
                        return_date DATE
                    )";
        if (mysqli_query($link, $create_sql)) {
            // echo "Table borrowed_books created successfully";
        } else {
            echo "Error creating table: " . mysqli_error($link);
        }
    }
}

// Call the function to create the table if the user is logged in
checkAndCreateTable();

// Function to get borrowed books
function getBorrowedBooks()
{
    global $link;
    $sql = "SELECT * FROM borrowed_books";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        die("Error: " . mysqli_error($link));
    }
    return $result;
}

// Call the function to get borrowed books
$borrowedBooks = getBorrowedBooks();

// Set last visited page cookie
setLastVisitedPageCookie('Borrowed Books');

$lastVisitedPage = isset($_COOKIE['last_visited_page']) ? $_COOKIE['last_visited_page'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrowed Books</title>
    <link rel="stylesheet" href="borrowed_css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"><!--for icon with navbar -->
</head>

<body>
    <ul>
        <li><a href="library_books.php"><i class="fa fa-fw fa-home"></i>Home</a></li>
        <li><a href="search_books.php"><i class="fa fa-fw fa-search"></i>Search Books</a></li>
        <li><a class="active" href="borrowed_books.php"><i class="fa fa-fw fa-book"></i>Borrowed Books</a></li>
        <li><a href="return_books.php"><i class="fa fa-fw fa-reply"></i>Return Books</a></li>
        <li><a href="feedback.php" class="dropbtn"><i class="fa fa-fw fa-commenting"></i>Feedback</a></li>
        <li><a href="contact_me.php" title="If you have any query you can ask us"><i class="fa fa-fw fa-envelope"></i>Contact Us</a></li>
        <li style="float:right"><a href="login.php"><i class="fa fa-fw fa-user"></i>Login</a></li>
    </ul>
    <h1>Borrowed Books</h1>
    <?php
    if (mysqli_num_rows($borrowedBooks) > 0) {
        echo '<table>';
        echo "<thead>";
        echo "<tr>";
        echo "<th>Book id</th>";
        echo "<th>Title</th>";
        echo "<th>Author</th>";
        echo "<th>Borrowed Date</th>";
        echo "<th>Return Date</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while ($row = mysqli_fetch_array($borrowedBooks)) {
            echo "<tr>";
            echo "<td>" . $row['book_id'] . "</td>";
            echo "<td>" . $row['title'] . "</td>";
            echo "<td>" . $row['author'] . "</td>";
            echo "<td>" . $row['borrowed_date'] . "</td>";
            echo "<td>" . $row['return_date'] . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo '<em>No records were found.</em>';
    }
    ?>
    <hr>

    <footer>
        <?php
        if (isset($_COOKIE['last_visited_page'])) {
            $lastVisitedPage = $_COOKIE['last_visited_page'];
            echo "Last visited page: " . $lastVisitedPage;
        }
        ?>
        <p style="text-align: center;">&copy;  2024. All rights reserved.</p>

        <a href="search_books.php"><button style="float: left;"><i class="fa fa-fw fa-arrow-left"></i>Previous</button></a>
        <a href="return_books.php"><button style="float: right;">Next<i class="fa fa-fw fa-arrow-right"></i></button></a>
    </footer>
</body>

</html>