<?php
require 'header.php';
require 'articlesDAO.php';

//checks post token, user is logged in, etc.
require 'redirect.php';

$id = $_POST['id'];
$title = $_POST['title'];
$story = $_POST['story'];
$link = $_POST['url'];

$articlesDAO = new ArticlesDAO();

if($articlesDAO->modifyArticle($id,$link, $title, $story)){
    return header("Location: http://ec2-3-136-160-212.us-east-2.compute.amazonaws.com/m3/read.php?article_id=".$id); 
} else{
   // Error code prints
}

