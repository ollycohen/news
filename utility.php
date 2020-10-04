<?php
class Utility
{

    public function checkUser()
    {
        return isset($_SESSION["user"]);
    }

    public function checkSessionToken()
    {
        return isset($_SESSION["token"]);
    }

    public function checkPostToken()
    {
        if (
            isset($_SESSION["token"]) &&
            isset($_POST["token"]) &&
            hash_equals($_SESSION['token'], $_POST['token'])
        ) {
            return true;
        }
        return false;
    }
}
