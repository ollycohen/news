<?php
require_once 'commentsDAO.php';
require_once 'likesDAO.php';
class ArticlesDAO
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

    // Post article inserts article into articles table  
    public function postArticle($link, $user, $title, $story)
    {
        if ($stmt = $this->database->prepare("INSERT INTO articles (link, username, title, story) VALUES (?,?,?,?)")) {
            $stmt->bind_param('ssss', $link, $user, $title, $story);
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

    // Queries all articles from articles table to display on main news page
    public function retrieveAllArticles()
    {
        // https://classes.engineering.wustl.edu/cse330/index.php?title=PHP_and_MySQL
        $stories = $this->database->prepare("select article_id, link, username, title from articles");
        if (!$stories) {
            printf("Query Prep Failed: %s\n", $this->database->error);
            exit;
        }

        $stories->execute();

        $result = $stories->get_result();

        $display = array();

        while ($row = $result->fetch_assoc()) {
            array_push($display, $row);
        }
        return $display;
    }

    // Deletes article from databse
    public function deleteArticle($article_id)
    {
        $commentsDAO = new CommentsDAO();
        $commentsDAO->deleteArticleComments($article_id);
        $likesDAO = new LikesDAO();
        $likesDAO->deleteArticleLikes($article_id);
        if ($stmt = $this->database->prepare("DELETE from articles where article_id= ?")) {
            $stmt->bind_param('s', $article_id);
            $success = false;
            if ($stmt->execute()) {
                $success = true;
            }
            $stmt->close();
            return $success;
        }
        printf("Query Prep Failed: %s\n", $this->database->error);
        return false;
    }

    // Gets the article to display on read.php
    public function readArticle($id)
    {
        if ($stmt = $this->database->prepare("select link, username, title, story, votes, DATE_FORMAT( `timestamp` , '%H:%i:%s on %d-%m-%Y' ) as timestamp from articles where article_id = ? ")) {
            // select link, username, title, story, votes, comments.body from articles where article_id=? join comments on (articles.articles_id=comments.comment_id);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $article = array();
            while ($row = $result->fetch_assoc()) {
                array_push($article, $row);
            }
            return $article[0];
        } else {
            printf("Query Prep Failed: %s\n", $this->database->error);
            return false;
        }
    }

    // Gets the article details to edit in editArticle.php
    public function showEditArticleDetails($id)
    {
        if ($stmt = $this->database->prepare("select link, title, story from articles where article_id = ? ")) {
            // select link, username, title, story, votes, comments.body from articles where article_id=? join comments on (articles.articles_id=comments.comment_id);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $article = array();
            while ($row = $result->fetch_assoc()) {
                array_push($article, $row);
            }
            return $article[0];
        } else {
            printf("Query Prep Failed: %s\n", $this->database->error);
            return false;
        }
    }

    // Updates article in database after edited
    public function modifyArticle($id, $link, $title, $story)
    {
        if ($stmt = $this->database->prepare("update articles SET link = ?, title=?, story=? where article_id =?")) {
            $stmt->bind_param('sssi', $link, $title, $story, $id);
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
