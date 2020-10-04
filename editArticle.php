<?php
require 'header.php';
require 'articlesDAO.php';

//checks post token, user is logged in, etc.
require 'redirect.php';

$articlesDAO = new ArticlesDAO();
$id = $_POST['article_id'];

if($article = $articlesDAO->showEditArticleDetails($id)){
?>
<h2> Edit Your Article </h2>
<br>
<div class="form-group">
    <form action="postEditedArticle.php" method="POST">
        <p>Title: <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($article['title']); ?>"></p>
        <p>Story:</p>
        <textarea name="story" rows="5" cols="50" class="form-control"><?php echo htmlspecialchars($article['story']); ?></textarea>
        <br>
        <p>External Link: <input type="url" name="url" class="form-control" value="<?php echo htmlspecialchars($article['link']); ?>"></p>
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
        <input type="hidden" name="id" value="<?php echo htmlentities($id)?>">
        <input type="submit" value="post" class="form-control">
    </form>
</div>
<?php 
} 
require "footer.php";