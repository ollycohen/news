<?php
require "header.php";
require "likesDAO.php";

//checks post token, user is logged in, etc.
require 'redirect.php';

$article_id = $_POST['article_id'];

$likesDAO = new LikesDAO();
if ($likesDAO->like($article_id, $user)) {
    header("Location: http://ec2-3-136-160-212.us-east-2.compute.amazonaws.com/m3/read.php?article_id=" . $article_id);
} else {
    printf("Failed to like.");
}
