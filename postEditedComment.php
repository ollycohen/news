<?php

require 'commentsDAO.php';
require 'header.php';

//checks post token, user is logged in, etc.
require 'redirect.php';

$body = $_POST['body'];
$comment_id = $_POST['comment_id'];
$article_id = $_POST['article_id'];

$commentsDAO = new CommentsDAO();

if($commentsDAO->modifyComment($comment_id, $body)){
    return header("Location: http://ec2-3-136-160-212.us-east-2.compute.amazonaws.com/m3/read.php?article_id=".$article_id); 
}else{
    // Error code prints
}


