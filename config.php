<html>

<head>
    <title>Book Store</title>
    <meta charset="UTF-8">
</head>
<link rel="stylesheet" href="config_css.css">

<body>
    <?php
    session_start();

    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'library_books');

    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);


    if ($link === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    function setLastVisitedPageCookie($page)
    {
        setcookie('last_visited_page', $page, time() + (86400 * 30), "/");
    }

    if (!isset($_COOKIE['last_visited_page'])) {
        setLastVisitedPageCookie($_SERVER['PHP_SELF']);
    }

    $lastVisitedPage = isset($_COOKIE['last_visited_page']) ? $_COOKIE['last_visited_page'] : '';

    ?>

</body>

</html>