<?php
class CommentsDAO
{
    private $database;

    // Connect to database
    public function __construct()
    {
        // https://classes.engineering.wustl.edu/cse330/index.php?title=PHP_and_MySQL#Connecting_to_a_MySQL_Database_in_PHP
        $this->database = new mysqli('localhost', 'phpuser', 'php', 'news');
        if ($this->database->connect_error) {
            die('Connect Error (' . $this->database->connect_errno . ') ' . $this->database->connect_error);
        }
    }

    // Get comments for specific article 
    public function getArticleComments($article_id)
    {
        if ($stmt = $this->database->prepare("select comment_id, body, username, article_id, DATE_FORMAT( `timestamp` , '%H:%i:%s on %d-%m-%Y' ) as timestamp from comments where article_id = ?")) {
            $stmt->bind_param('i', $article_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $comments = array();
            while ($row = $result->fetch_assoc()) {
                array_push($comments, $row);
            }
            return $comments;
        }
    }

    // Delete all of the comments from an article
    public function deleteArticleComments($article_id)
    {
        if ($stmt = $this->database->prepare("DELETE FROM comments where article_id = ?")) {
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

    // Inserts comment to post into database 
    public function postComment($article_id, $username, $body)
    {
        if ($stmt = $this->database->prepare("INSERT INTO comments (body, username, article_id) VALUES (?,?,?)")) {
            $stmt->bind_param('sss', $body, $username, $article_id);
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

    // Deletes comment from database
    public function deleteComment($comment_id, $username)
    {

        // Get username from the database for this comment
        if ($stmt = $this->database->prepare("SELECT username FROM comments WHERE comment_id = ? ")) {
            $stmt->bind_param('i', $comment_id);
            $stmt->execute();
            $stmt->bind_result($username_in_DB);
            $stmt->fetch();
            $stmt->close();
        } else {
            printf("Query Prep Failed: %s\n", $this->database->error);
            return false;
        }

        // Check if the right user is deleting
        if (strcmp($username, $username_in_DB) != 0) {
            printf("Comment belongs to another user: cannot delete");
            return false;
        }

        // Delete the comment
        if ($stmt = $this->database->prepare("DELETE FROM comments where comment_id = ?")) {
            $stmt->bind_param('i', $comment_id);
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


    public function modifyComment($comment_id, $body)
    {
        if ($stmt = $this->database->prepare("update comments SET body = ? where comment_id =?")) {
            $stmt->bind_param('si', $body, $comment_id);
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
