<!DOCTYPE html>
<html>
<head>
    <title>Library Management System</title>
</head>
<body>
    <h1>Library Management System</h1>
    <form action="process.php" method="post">
        <label for="member">Member:</label><br>
        <input type="text" id="member" name="member"><br>
        
        <label for="isbn">Book ISBN:</label><br>
        <input type="text" id="isbn" name="isbn"><br>
        
        <label for="action">Action:</label><br>
        <select id="action" name="action">
            <option value="issue">Issue Book</option>
            <option value="return">Return Book</option>
        </select><br><br>
        
        <input type="submit" value="Submit">
    </form>
</body>
</html>
<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online bool";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $member = $_POST["member"];
    $isbn = $_POST["isbn"];
    $action = $_POST["action"];
    
    // Execute appropriate action based on user selection
    if ($action == "issue") {
        // Execute SQL query to issue the book
        $sql_issue = "INSERT INTO book_issue (member, book_isbn) VALUES ('$member', '$isbn')";
        if ($conn->query($sql_issue) === TRUE) {
            echo "Book issued successfully.";
        } else {
            echo "Error issuing book: " . $conn->error;
        }
    } elseif ($action == "return") {
        // Execute SQL query to return the book
        $sql_return = "DELETE FROM book_issue WHERE member = '$member' AND book_isbn = '$isbn'";
        if ($conn->query($sql_return) === TRUE) {
            echo "Book returned successfully.";
        } else {
            echo "Error returning book: " . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>
