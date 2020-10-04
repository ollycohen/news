<?php
// Origin from read.php when delete comment clicked
require "commentsDAO.php";

//checks post token, user is logged in, etc.
require 'redirect.php';

session_start();

$comment_id = $_POST['comment_id'];
$article_id = $_POST['article_id'];
$user = $_SESSION['user'];

$commentsDAO = new CommentsDAO();
if ($commentsDAO->deleteComment($comment_id, $user)) {
    header("Location: http://ec2-3-136-160-212.us-east-2.compute.amazonaws.com/m3/read.php?article_id=" . $article_id);
} else {
    printf("Failed to delete comment.");
}
