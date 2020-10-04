<?php
require 'usersDAO.php';

$user = $_POST['user'];
$password = $_POST['password'];

// Filter input by checking regex of username
if (!preg_match('/^[a-z\d_]{3,20}$/i', $user)) {
    return header("Location: http://ec2-3-136-160-212.us-east-2.compute.amazonaws.com/m3/welcome.php?fail_login=true");
}

// Set the user token during log in
$usersDAO = new UsersDAO();
if ($usersDAO->login($user, $password)) {
    session_start();
    $_SESSION['user'] = $user;
    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
    return header("Location: http://ec2-3-136-160-212.us-east-2.compute.amazonaws.com/m3/news.php");
} else {
    return header("Location: http://ec2-3-136-160-212.us-east-2.compute.amazonaws.com/m3/welcome.php?fail_login=true");
}
