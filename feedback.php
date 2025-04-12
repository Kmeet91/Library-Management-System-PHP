<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link rel="stylesheet" href="feedback_css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!--for icon with navbar -->
</head>

<body>

    <ul>
        <li><a href="library_books.php"><i class="fa fa-fw fa-home"></i>Home</a></li>
        <li><a href="search_books.php"><i class="fa fa-fw fa-search"></i>Search Books</a></li>
        <li><a href="borrowed_books.php"><i class="fa fa-fw fa-book"></i>Borrowed Books</a></li>
        <li><a href="return_books.php"><i class="fa fa-fw fa-reply"></i>Return Books</a></li>
        <li><a class="active" href="feedback.php" class="dropbtn"><i class="fa fa-fw fa-commenting"></i>Feedback</a></li>
        <li><a href="contact_me.php" title="If you have any query you can ask us"><i class="fa fa-fw fa-envelope"></i>Contact Us</a></li>
        <li style="float:right"><a href="login.php"><i class="fa fa-fw fa-user"></i>Login</a></li>
    </ul>
    <?php
    include "config.php";

    setLastVisitedPageCookie('Feedback');

    $name = $email = $feedback = "";
    $submitted = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $name = test_input($_POST["name"]);
        $email = test_input($_POST["email"]);
        $feedback = test_input($_POST["feedback"]);

        $submitted = true;
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>

    <?php if (!$submitted) : ?>
        <div class="container">
            <h1 class="feedback">Feedback Form</h1>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="name">Your Name:</label>
                    <input type="text" id="name" name="name" placeholder="Your name..." required>
                </div>
                <div class="form-group">
                    <label for="email">Your Email:</label>
                    <input type="email" id="email" name="email" placeholder="Your E-mail..." required>
                </div>
                <div class="form-group">
                    <label for="feedback">Your Feedback:</label>
                    <textarea id="feedback" name="feedback" rows="5" placeholder="Your feedback..." required></textarea>
                </div>
                <div class="form-group">
                    <button type="submit"><i class="fa fa-fw fa-paper-plane"></i>Submit</button>
                </div>
            </form>
        </div>
    <?php else : ?>

        <h2>Submitted Feedback:</h2>
        <p><strong>Name:</strong> <?php echo $name; ?></p>
        <p><strong>Email:</strong> <?php echo $email; ?></p>
        <p><strong>Feedback:</strong> <?php echo $feedback; ?></p>
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

        <a href="return_books.php"><button style="float: left;"><i class="fa fa-fw fa-arrow-left"></i>Previous</button></a>
        <a href="contact_me.php"><button style="float: right;">Next<i class="fa fa-fw fa-arrow-right"></i></button></a>
    </footer>
</body>

</html>