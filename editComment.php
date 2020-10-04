<?php
require 'header.php';

//checks post token, user is logged in, etc.
require 'redirect.php';

$comment_id = $_POST['comment_id'];
$username = $_POST['username'];
$body = $_POST['body'];
$timestamp = $_POST['timestamp'];
$article_id = $_POST['article_id'];

?>
<h2> Edit Your Comment </h2>
<br>
<div class="form-group">
    <form action="postEditedComment.php" method="POST">
        <p>Posted by:<em> <?php echo htmlspecialchars($username); ?> </em> </p>
        <p> at time: <?php echo htmlspecialchars($timestamp); ?> </p>
        <textarea name="body" rows="5" cols="50" class="form-control"><?php echo htmlspecialchars($body); ?></textarea>
        <input type="hidden" name="comment_id" value="<?php echo htmlspecialchars($comment_id) ?>">
        <input type="hidden" name="article_id" value="<?php echo htmlspecialchars($article_id) ?>">
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
        <input type="submit" value="Post" class="form-control">
    </form>
</div>
<?php
require 'footer.php';
