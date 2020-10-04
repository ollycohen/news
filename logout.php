<?php
session_start();
session_destroy();
return header("Location: http://ec2-3-136-160-212.us-east-2.compute.amazonaws.com/m3/news.php");
