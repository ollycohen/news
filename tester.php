<?php session_start();
$username = $_SESSION['user']; ?>
<form action="postComment.php" method="POST">
    text: <input type="text" name="body" />
    article_id: <input type="text" name="article_id" />
    <input type="hidden" name="user" value="<?php $username ?>" />
    <input type="submit" value="write a comment" />
</form>
<br>
<form action="deleteComment.php" method="POST">
    comment_id: <input type="text" name="comment_id" />
    <input type="hidden" name="user" value="<?php $username ?>" />
    <input type="submit" value="delete a comment" />
</form>