<!-- Login / signup page for users -->
<?php require 'header.php'; ?>
<div class="jumbotron">
    <h1>Welcome to TroZannews!</h1>
    <h2>"The source for your news"</h2>
</div>
<br>
<h5>Log in:</h5>
<form action="login.php" method="POST">
    <p>Username: <input type="text" name="user"></p>
    <p>Password: <input type="password" name="password"></p>
    <button type="submit" class="btn btn-primary" name="login">Log In</button>
</form>
<br>
<?php
$fail_signup = isset($_GET['fail_signup']) ? true : false;
$fail_login = isset($_GET['fail_login']) ? true : false;
if ($fail_signup) {
    echo "<br><div class='alert alert-primary'>Username is taken or invalid, please try a different one.</div><br>";
} else if ($fail_login) {
    echo "<br><div class='alert alert-primary'>Username or password was invalid, please try again.</div><br>";
}
?>
<form action="signup.php" method="POST">
    <h5> New to TroZannews? Sign up:</h5>
    <p> Username: <input type="text" name="user"></p>
    <p> Password: <input type="password" name="password"> </p>
    <button type="submit" class="btn btn-primary" name="signup">Sign Up</button>
</form>
<br>
<?php require "footer.php";
