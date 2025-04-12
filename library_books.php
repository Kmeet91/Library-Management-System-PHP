<!DOCTYPE html>
<html>

<head>
  <title>Library Books</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="library_css.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!--for icon with navbar -->
</head>

<body>
  <h1>Welcome to the Library Books System
    <?php

    include "config.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $username = $_POST['username'];
      echo ",$username";
    }

    ?></h1>
  <ul>
    <li><a class="active" href="library_books.php"><i class="fa fa-fw fa-home"></i>Home</a></li>
    <li><a href="search_books.php"><i class="fa fa-fw fa-search"></i>Search Books</a></li>
    <li><a href="borrowed_books.php"><i class="fa fa-fw fa-book"></i>Borrowed Books</a></li>
    <li><a href="return_books.php"><i class="fa fa-fw fa-reply"></i>Return Books</a></li>
    <li><a href="feedback.php" class="dropbtn"><i class="fa fa-fw fa-commenting"></i>Feedback</a></li>
    <li><a href="contact_me.php" title="If you have any query you can ask us"><i class="fa fa-fw fa-envelope"></i>Contact Us</a></li>
    <li style="float:right"><a href="login.php"><i class="fa fa-fw fa-user"></i>Login</a></li>
    
    <!-- <li style="float:right" class="dropdown">
      <div class="dropdown-content">
        <a href="login.php">Login</a>
        <a href="logout.php">Logout</a>
      </div>
    </li> -->
  </ul>
  <br>

  <?php
  require_once "config.php";
  setLastVisitedPageCookie('Home');


  $sql = "SELECT book_id, title, author, genre, publication_year, price, language, quantity FROM books"; 
  if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
      echo '<table>';
      echo "<thead>";
      echo "<tr>";
      echo "<th>Book ID</th>"; 
      echo "<th>Title</th>";
      echo "<th>Author</th>";
      echo "<th>Genre</th>";
      echo "<th>Publication Year</th>";
      echo "<th>Price</th>";
      echo "<th>Language</th>";
      echo "<th>Quantity</th>";
      echo "</tr>";
      echo "</thead>";
      echo "<tbody>";
      while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" . $row['book_id'] . "</td>"; 
        echo "<td>" . $row['title'] . "</td>";
        echo "<td>" . $row['author'] . "</td>";
        echo "<td>" . $row['genre'] . "</td>";
        echo "<td>" . $row['publication_year'] . "</td>";
        echo "<td>" . $row['price'] . "</td>";
        echo "<td>" . $row['language'] . "</td>";
        echo "<td>" . $row['quantity'] . "</td>";
        echo "</tr>";
      }
      echo "</tbody>";
      echo "</table>";
      mysqli_free_result($result);
    } else {
      echo '<em>No records were found.</em>';
    }
  } else {
    echo "Oops! Something went wrong. Please try again later.";
  }

  mysqli_close($link);
  ?>
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
    <a href="search_books.php"><button style="float: right;">Next<i class="fa fa-fw fa-arrow-right"></i></button></a>
  </footer>
</body>

</html>