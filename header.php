<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Bootstrap CSS (https://getbootstrap.com/) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="css/news.css">
    <title>Trozannews</title>
</head>

<body>
    <?php
    // Start Session
    session_start();
    require "utility.php";
    $utility = new Utility();
    $user_exists = false;
    // checks session and sets user variable equal to session user
    if ($utility->checkUser()) {
        $user_exists = true;
        $user = $_SESSION['user'];
    }
    // checks token
    $session_token_exists = $utility->checkSessionToken();
    $post_token_valid = $utility->checkPostToken();

    ?>
    <nav class="navbar" id="top-nav">
        <a href="/m3/news.php" class="btn" id="home">Trozannews</a>
        <?php
        if ($user_exists) {
        ?>
            <a class="btn btn-secondary"> Welcome <?php echo htmlspecialchars($user) ?>!</a>
            <a href="/m3/writeArticle.php" class="btn">Write Article</a>
            <a href="/m3/logout.php" class="btn">Log Out</a>
        <?php
        } else {
        ?>
            <a href="/m3/welcome.php" class="btn">Log In or Sign Up</a>
        <?php
        }
        ?>
    </nav>

    <div class="container">
        <br>
        <br>
        <br>
        <br>