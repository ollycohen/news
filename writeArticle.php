<?php
require 'header.php';

// Redirect to news homepage if they're not logged in
if (!$user_exists) {
    header("Location: http://ec2-3-136-160-212.us-east-2.compute.amazonaws.com/m3/news.php");
}

// Rediret to login (and log them out) if there's no session token
if (!$session_token_exists) {
    header("Location: http://ec2-3-136-160-212.us-east-2.compute.amazonaws.com/m3/logout.php");
}

?>
<h2> Add an Article </h2>
<br>
<div class="form-group">
    <form action="postArticle.php" method="POST">
        <p>Title: <input type="text" name="title" class="form-control"></p>
        <p>Story:</p>
        <textarea name="story" rows="5" cols="50" class="form-control">
        </textarea>
        <br>
        <p>External Link: <input type="url" name="url" class="form-control"></p>
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
        <input type="submit" value="post" class="form-control">
    </form>
</div>
<?php require "footer.php";
