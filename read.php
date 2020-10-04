<?php
// In this page, we read a specific article 
require_once 'articlesDAO.php';
require_once 'commentsDAO.php';
require_once 'likeButton.php';
require 'header.php';

// Get article id or return error if it's not set 
if (isset($_GET['article_id'])) {
        $article_id = $_GET['article_id'];
} else {
        header("Location: http://ec2-3-136-160-212.us-east-2.compute.amazonaws.com/m3/error.php");
}

$likeButton = new LikeButton();
$articlesDAO = new ArticlesDAO();
if ($article = $articlesDAO->readArticle($article_id)) {
?>
        <h2> <?php echo htmlspecialchars($article['title']) ?> </h2>
        <p><i>posted by <?php echo htmlspecialchars($article['username']); ?> at <?php echo $article['timestamp']; ?> </i></p>
        <br>
        <p class="jumbotron"><?php echo htmlspecialchars($article['story']); ?></p>
        <a class="btn btn-light" href="<?php echo htmlspecialchars($article['link']); ?>" target="_blank">External Link</a>
        <?php
        if ($user_exists) {
                $mine = strcmp($user, $article['username']) == 0;
        } else {
                $mine = false;
        }
        if ($mine) {
                // if article belongs to user, delete and edit buttons appear
        ?>
                <div class="btn-group">
                        <form action="deleteArticle.php" method="POST">
                                <input type="hidden" name="article_id" value="<?php echo htmlspecialchars($article_id); ?>">
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                                <input type="submit" class="btn btn-danger" value="Delete Article">
                        </form>
                        <form action="editArticle.php" method="POST">
                                <input type="hidden" name="article_id" value="<?php echo htmlspecialchars($article_id); ?>">
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                                <input type="submit" class="btn btn-primary" value="Edit Article">
                        </form>
                </div>
<?php
        }
        // if user is signed in, like button appears
        if ($user_exists) {
                echo $likeButton->buttonHTML($article_id, $user);
        }
} else {
        header("Location: http://ec2-3-136-160-212.us-east-2.compute.amazonaws.com/m3/error.php");
}

?>
<div class="container">
        <br><br>
        <h4>Comments</h4>
        <ul class="list-group">
                <?php
                //retrieve comments here
                $commentsDAO = new CommentsDAO();
                if ($comments = $commentsDAO->getArticleComments($article_id)) {
                        foreach ($comments as &$comment) {
                ?>
                                <li class="list-group-item">
                                        <b><?php echo htmlspecialchars($comment['username']) ?></b> at
                                        <b><?php echo htmlspecialchars($comment['timestamp']) ?></b>:
                                        <br>
                                        <?php echo htmlspecialchars($comment['body']) ?>
                                        <br>
                                        <?php if ($user_exists && strcmp($user, $comment['username']) == 0) {
                                                // If comment belongs to user, delete and edit buttons appear
                                        ?>
                                                <div class="btn-group">
                                                        <form action="deleteComment.php" method="POST">
                                                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
                                                                <input type="hidden" name="comment_id" value="<?php echo $comment['comment_id']; ?>" />
                                                                <input type="hidden" name="article_id" value="<?php echo htmlspecialchars($comment['article_id']); ?>">
                                                                <input type="submit" class="btn btn-danger" value="Delete Comment" />
                                                        </form>
                                                        <form action="editComment.php" method="POST">
                                                                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                                                                <input type="hidden" name="comment_id" value="<?php echo htmlspecialchars($comment['comment_id']); ?>">
                                                                <input type="hidden" name="body" value="<?php echo htmlspecialchars($comment['body']); ?>">
                                                                <input type="hidden" name="timestamp" value="<?php echo htmlspecialchars($comment['timestamp']); ?>">
                                                                <input type="hidden" name="username" value="<?php echo htmlspecialchars($comment['username']); ?>">
                                                                <input type="hidden" name="article_id" value="<?php echo htmlspecialchars($comment['article_id']); ?>">
                                                                <input type="submit" value="Edit Comment" class="btn btn-primary">
                                                        </form>
                                                </div>
                                        <?php } ?>
                                </li>
                <?php }
                } ?>
        </ul>
        <?php if ($user_exists) { ?>
                <div class="form-group">
                        <form action="postComment.php" method="POST">
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                                <textarea placeholder="Write a Comment" id="comment-box" rows="3" cols="50" class="form-control" name="body"></textarea>
                                <input type="hidden" name="article_id" value="<?php echo htmlspecialchars($article_id); ?>" />
                                <input type="submit" class="btn btn-primary" value="Post Comment" />
                        </form>
                </div>
        <?php } ?>
</div> 
<?php
require "footer.php";
