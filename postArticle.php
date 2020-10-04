<?php
require "header.php";
require "articlesDAO.php";

//checks post token, user is logged in, etc.
require 'redirect.php';

$title = $_POST['title'];
$story = $_POST['story'];
$link = $_POST['url'];


$articlesDAO = new ArticlesDAO();
if ($articlesDAO->postArticle($link, $user, $title, $story)) {
    header("Location: http://ec2-3-136-160-212.us-east-2.compute.amazonaws.com/m3/news.php");
} else {
    printf("Failed to post.");
}



