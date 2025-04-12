<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="contact_mecss.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!--for icon with navbar -->
</head>

<body>
    <ul>
        <li><a href="library_books.php"><i class="fa fa-fw fa-home"></i>Home</a></li>
        <li><a href="search_books.php"><i class="fa fa-fw fa-search"></i>Search Books</a></li>
        <li><a href="borrowed_books.php"><i class="fa fa-fw fa-book"></i>Borrowed Books</a></li>
        <li><a href="return_books.php"><i class="fa fa-fw fa-reply"></i>Return Books</a></li>
        <li><a href="feedback.php" class="dropbtn"><i class="fa fa-fw fa-commenting"></i>Feedback</a></li>
        <li><a class="active" href="contact_me.php" title="If you have any query you can ask us"><i class="fa fa-fw fa-envelope"></i>Contact Us</a></li>
        <li style="float:right"><a href="login.php"><i class="fa fa-fw fa-user"></i>Login</a></li>
        <!-- This code correct still expected output not come<li class="dropdown" style="float:right">
      <a href="javascript:void(0)" class="dropbtn"><i class="fa fa-fw fa-user"></i></a>
      <div class="dropdown-content">
        <a href="login.php">Login</a>
        <a href="logout.php">Log out</a>  
      </div>
    </li> -->
    </ul>
    <div class="container">
        <h1>Contact Us</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="Your name..." required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Your E-mail..." required>
            </div>
            <div class="form-group">
                <label for="contact">Contact No:</label>
                <input type="text" id="contact" name="contact" placeholder="Your Contact No...">
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" placeholder="Your message..." required></textarea>
            </div>
            <div class="form-group">
                <button type="submit" onclick="msg()"><i class="fa fa-fw fa-paper-plane"></i>Submit</button>
            </div>
        </form>
        <?php
        include "config.php";
        setLastVisitedPageCookie('Contact_me');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $contact = $_POST['contact'];
            $message = $_POST['message'];

            echo "<h2>Thank you for contacting us, $name!</h2>";
            echo "<p>We have received your message:</p>";
            echo "<p><strong>Email:</strong> $email</p>";
            echo "<p><strong>Contact No:</strong> $contact</p>";
            echo "<p><strong>Message:</strong> $message</p>";
        }
        ?>
    </div>
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

        <a href="feedback.php"><button style="float: left;"><i class="fa fa-fw fa-arrow-left"></i>Previous</button></a>
        <a href="library_books.php"><button style="float: right;"><i class="fa fa-fw fa-home"></i>Home</button></a>
    </footer>
</body>

</html>