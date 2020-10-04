<?php
require "commentsDAO.php";

//checks post token, user is logged in, etc.
require 'redirect.php';

session_start();

$body = $_POST['body'];
$article_id = $_POST['article_id'];
$user = $_SESSION['user'];

$commentsDAO = new CommentsDAO();
if ($commentsDAO->postComment($article_id, $user, $body)) {
	header("Location: http://ec2-3-136-160-212.us-east-2.compute.amazonaws.com/m3/read.php?article_id=".$article_id);
} else {
    // Error code prints
}
