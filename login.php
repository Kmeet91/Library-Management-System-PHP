<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="logincss.css">
</head>

<body>

    <div class="container">
        <h2>Login</h2>
        <form id="loginForm" method="post">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="Submit">
        </form>
    </div>

    <script>
        // Function to change form action based on referring page
        document.addEventListener("DOMContentLoaded", function() {
            var referringPage = document.referrer; // Get the referring page URL
            var destinationPage = referringPage || "library_books.php"; // Default redirect page after login

            // Set form action to the destination page
            document.getElementById("loginForm").action = destinationPage;
        });
    </script>
</body>

</html>
<?php
include "config.php";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST["username"]) and isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $_SESSION['logged-in'] = true;
    } else {
        echo "<h1>Please enter username and password.</h1>";
    }
}
?>