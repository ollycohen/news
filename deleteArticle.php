<?php
// Origin from news.php or read.php when delete article clicked
require 'header.php';
require 'articlesDAO.php';

//checks post token, user is logged in, etc.
require 'redirect.php';

$article_id = $_POST['article_id'];

$articlesDAO = new ArticlesDAO();
if($articlesDAO->deleteArticle($article_id)){
    return header("Location: http://ec2-3-136-160-212.us-east-2.compute.amazonaws.com/m3/news.php"); 
} else {
    return header("Location: http://ec2-3-136-160-212.us-east-2.compute.amazonaws.com/m3/error.php"); 
}