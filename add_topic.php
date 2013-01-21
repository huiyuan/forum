<?php
define('FORUM_ROOT', './');
require FORUM_ROOT . 'common.php';

// Your code goes here!
$id = isset($_POST['id'])?trim($_POST['id']): "";		// get forum id
//$user_id = isset($_GET['user_id'])?trim($_GET['user_id']) :"";
//$user_name = isset($_GET['user_name'])?trim($_GET['user_name']) :"";

if(empty($user_name)) {
	$user_name = isset($_POST['name'])? trim($_POST['name']): " ";
}
if(empty($user_name)) {
	$user_name = "Anonymous";	
}

$subject = $_POST['subject'];
$message = isset($_POST['message'])?trim($_POST['message']): " ";
$cur_time = date("Y-m-d H:i:s");


$new_topic = $dbh->prepare('INSERT INTO topics (subject,author,num_replies,last_poster,last_post_time,forum_id)
 VALUES (:subject, :user_name, 0, :user_name, :cur_time, :forum_id)');
$new_topic ->bindParam(':user_name', $user_name, PDO::PARAM_STR);
$new_topic ->bindParam(':subject', $subject, PDO::PARAM_STR);
$new_topic ->bindParam(':forum_id', $id, PDO::PARAM_INT);
$new_topic ->bindParam(':cur_time', $cur_time, PDO::PARAM_STR);
$new_topic ->execute();

$new_topic_id = $dbh->lastInsertId();

$new_post = $dbh->prepare('INSERT INTO posts (author, author_id,posted_time,contents,topic_id) VALUES (:user_name, :user_id, :cur_time, :contents, :topic_id)');
$new_post ->bindParam(':user_name', $user_name, PDO::PARAM_STR);
$new_post ->bindParam(':user_id', $user_id, PDO::PARAM_INT);	
$new_post ->bindParam(':cur_time', $cur_time, PDO::PARAM_STR);
$new_post ->bindParam(':contents', $message, PDO::PARAM_STR);
$new_post ->bindParam(':topic_id', $new_topic_id, PDO::PARAM_INT);
$new_post ->execute();

$update_forum = $dbh->prepare('UPDATE forums SET num_topics = num_topics + 1, num_posts = num_posts + 1 WHERE forum_id = :forum_id');
$update_forum ->bindParam(':forum_id', $id, PDO::PARAM_INT);
$update_forum ->execute();
?>