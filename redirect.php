<?php
// Redirect to news homepage if they're not logged in
if (!$user_exists) {
    header("Location: http://ec2-3-136-160-212.us-east-2.compute.amazonaws.com/m3/news.php");
}

// Rediret to login (and log them out) if there's no valid token posted
if (!$post_token_valid) {
    header("Location: http://ec2-3-136-160-212.us-east-2.compute.amazonaws.com/m3/logout.php");
}
