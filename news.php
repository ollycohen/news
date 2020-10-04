<?php
require "header.php";
require_once 'commentsDAO.php';
require_once 'likesDAO.php';
require_once 'articlesDAO.php';
require_once 'likeButton.php';
?>

<?php
$articlesDAO = new ArticlesDAO();
$likeButton = new LikeButton();
if ($articles = $articlesDAO->retrieveAllArticles()) {
    foreach ($articles as &$article) {
        // Boolean $mine checks if each article belongs to the user that's signed in
        if ($user_exists) {
            $mine = strcmp($user, $article['username']) == 0;
        } else {
            $mine = false;
        }
?>
        <div class="jumbotron">
            <a class="btn" href="/m3/read.php?article_id=<?php echo htmlspecialchars($article['article_id']); ?>">
                <h5><?php echo htmlspecialchars($article['title']); ?></h5>
            </a>
            <?php if ($mine) { ?>
                <!-- if the article belongs to the user, username appears in bold red-->
                <p><i>posted by: </i><strong id=me-username><?php echo htmlspecialchars($article['username']); ?></strong>
                <?php } else { ?>
                <!-- if the article does not belong to the user, username appears with no special formatting-->
                <p><i>posted by: </i><?php echo htmlspecialchars($article['username']); ?>
                <?php
                }
                    ?>
                    </p>
                    <a class="btn btn-light" href="<?php echo htmlspecialchars($article['link']); ?>" target="_blank">External Link</a>
                    <?php if ($mine) {
                    // If the article belongs to user, delete and edit buttons appear    
                    ?>
                        <div class="btn-group">
                            <form action="deleteArticle.php" method="POST">
                                <input type="hidden" name="article_id" value="<?php echo htmlspecialchars($article['article_id']); ?>">
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
                                <input type="submit" class="btn btn-danger" value="Delete">
                            </form>
                            <form action="editArticle.php" method="POST">
                                <input type="hidden" name="article_id" value="<?php echo htmlspecialchars($article['article_id']); ?>">
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
                                <input type="submit" value="Edit" class="btn btn-primary">
                            </form>
                        </div>
                    <?php
                    }
                    if ($user_exists) {
                        // if the user is signed in, like button appears
                        echo $likeButton->buttonHTML($article['article_id'], $user);
                    }
                    ?>

        </div>
<?php
    }
}
require "footer.php";
?>