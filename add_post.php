<?php
define('FORUM_ROOT', './');
require FORUM_ROOT . 'common.php';

$id = isset($_POST['id'])?intval($_POST['id']): "";
$forum_id = isset($_POST['forum_id'])?intval($_POST['forum_id']): "";
$message = isset($_POST['message'])?trim($_POST['message']): " ";
$cur_time = date("Y-m-d H:i:s");

if(empty($user_name)){
	$user_name = isset($_POST['name'])?trim($_POST['name']): "Anonymous";
}

// create new post
$new_post = $dbh->prepare('INSERT INTO posts (author,author_id,posted_time,contents,topic_id) VALUES (:name, :user_id, :cur_time, :contents, :topic_id)');
$new_post	->bindParam(':name', $user_name, PDO::PARAM_STR);
$new_post	->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$new_post	->bindParam(':contents', $message, PDO::PARAM_STR);
$new_post	->bindParam(':topic_id', $id, PDO::PARAM_INT);
$new_post	->bindParam(':cur_time', $cur_time, PDO::PARAM_STR);
$new_post ->execute();

// update topic table, increase the number of replies and update the last post time
$update_topic = $dbh->prepare('UPDATE topics SET num_replies = num_replies + 1, last_poster = :user_name, last_post_time= :cur_time WHERE topic_id = :topic_id');
$update_topic ->bindParam(':user_name', $user_name,PDO::PARAM_STR);
$update_topic ->bindParam(':cur_time', $cur_time,PDO::PARAM_STR);
$update_topic ->bindParam(':topic_id', $id, PDO::PARAM_INT);
$update_topic ->execute();

// update forum table, increase the number of posts
$update_forum = $dbh->prepare('UPDATE forums SET num_posts = num_posts + 1 WHERE forum_id = :forum_id');
$update_forum ->bindParam(':forum_id', $forum_id, PDO::PARAM_INT);
$update_forum ->execute();
?>