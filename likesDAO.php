<?php

class LikesDAO
{
    private $database;

    // Connect to Database
    public function __construct()
    {
        // https://classes.engineering.wustl.edu/cse330/index.php?title=PHP_and_MySQL#Connecting_to_a_MySQL_Database_in_PHP
        $this->database = new mysqli('localhost', 'phpuser', 'php', 'news');
        if ($this->database->connect_error) {
            die('Connect Error (' . $this->database->connect_errno . ') ' . $this->database->connect_error);
        }
    }

    // Get likes for specific article 
    public function getNumLikes($article_id)
    {
        if ($stmt = $this->database->prepare("SELECT * FROM likes where article_id = ?")) {
            $stmt->bind_param('i', $article_id);
            $stmt->execute();
            mysqli_stmt_store_result($stmt);
            return mysqli_stmt_num_rows($stmt);
        }
    }

    public function hasLiked($article_id, $username)
    {
        if ($stmt = $this->database->prepare("SELECT * FROM likes where (article_id = ? and username = ?)")) {
            $stmt->bind_param('is', $article_id, $username);
            $stmt->execute();
            mysqli_stmt_store_result($stmt);
            return (mysqli_stmt_num_rows($stmt) == 1);
        }
    }

    // Delete all of the likes from an article
    public function deleteArticleLikes($article_id)
    {
        if ($stmt = $this->database->prepare("DELETE FROM likes where article_id = ?")) {
            $stmt->bind_param("i", $article_id);
            $success = false;
            if ($stmt->execute()) {
                $success = true;
            } else {
                echo $article_id;
                printf("Query Prep Failed: %s\n", $this->database->error);
            }
            $stmt->close();
            return ($success);
        }
    }

    public function like($article_id, $username)
    {

        if ($stmt = $this->database->prepare("INSERT INTO likes (username, article_id) VALUES (?,?)")) {
            $stmt->bind_param('si', $username, $article_id);
            $success = false;
            if ($stmt->execute()) {
                $success = true;
            } else {
                echo $article_id;
                printf("Query Prep Failed: %s\n", $this->database->error);
            }
            $stmt->close();
            return ($success);
        }
        printf("Query Prep Failed: %s\n", $this->database->error);
        return false;
    }

    public function unlike($article_id, $username)
    {
        // Delete the like
        if ($stmt = $this->database->prepare("DELETE FROM likes where (article_id = ? and username = ?)")) {
            $stmt->bind_param('is', $article_id, $username);
            $success = false;
            if ($stmt->execute()) {
                $success = true;
            }
            $stmt->close();
            return ($success);
        }
        printf("Query Prep Failed: %s\n", $this->database->error);
        return false;
    }
}
