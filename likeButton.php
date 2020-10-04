<?php

class LikeButton
{
    var $likesDAO;
    public function __construct()
    {
        $this->likesDAO = new LikesDAO();
    }

    public function buttonHTML($article_id, $username)
    {
        $out = "";

        if ($this->likesDAO->hasLiked($article_id, $username)) {
            $out .= "<div class='btn-group'>";
            $out .= "<form action='unlike.php' method='POST'>";
            $out .= "<input type='submit' class='btn btn-info' value='unlike' />";
            $out .= "<input type='hidden' name='token' value='" . $_SESSION['token'] . "' />";
            $out .= "<input type='hidden' name='article_id' value='" . $article_id . "' />";
            $out .= "</form>";
            $out .= "<input type='button' class='btn' value='" . $this->likesDAO->getNumLikes($article_id) . "' />";
            $out .= "</div>";
        } else {
            $out .= "<div class='btn-group'>";
            $out .= "<form action='like.php' method='POST'>";
            $out .= "<input type='submit' class='btn btn-info' value='like' />";
            $out .= "<input type='hidden' name='token' value='" . $_SESSION['token'] . "' />";
            $out .= "<input type='hidden' name='article_id' value='" . $article_id . "' />";
            $out .= "</form>";
            $out .= "<input type='button' class='btn' value='" . $this->likesDAO->getNumLikes($article_id) . "' />";
            $out .= "</div>";
        }
        return $out;
    }
}
