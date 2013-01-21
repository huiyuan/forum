<?php
define('FORUM_ROOT', './');
require FORUM_ROOT . 'common.php';

// Your code goes here!
$PHP_SELF = $_SERVER['PHP_SELF'];
$cur_page = isset($_GET['page'])? intval($_GET['page']) : 1;

$limit = 20;
if (empty($cur_page)) {  $cur_page=1;  }
$forum_id = isset($_GET['id'])?trim($_GET['id']):'';

// Get topics 
$statement = sql_query('SELECT * FROM forums INNER JOIN categories ON forums.category_id = categories.category_id WHERE forum_id = ?',array($forum_id));
$result = $statement->fetchAll();
$forum_info = $result[0];

$statement = sql_query('SELECT * FROM topics WHERE forum_id = ? ORDER BY last_post_time DESC LIMIT ' . (($cur_page-1) * 20) . ', 20',array($forum_id));

$topic_list = array();
while($result = $statement->fetch(PDO::FETCH_ASSOC)){
	$topic_list[] = $result;
}

require_once "header.php";
?>

<div id="main">
	<div class="breadcrumb">
		<p><a href="index.php" >HOME</a><a href="index.php">▹<?php echo htmlspecialchars($forum_info['category_name']);?></a>
		<a>▹<?php echo htmlspecialchars($forum_info['forum_name']);?></a></p>
	</div>
	<?php if($topic_list) { ?>
	<div>	
		<table>
			<tr><th class="">Topic</th><th>Author</th><th>Replies</th><th>Last Poster</th><th>Last Post Time</th></tr>
			<tbody>
			<?php
				foreach($topic_list as $topic): ?>
				<tr>
					<td class="col1"><a href="view-topic.php?id=<?php echo $topic['topic_id']; ?>" ><?php echo htmlspecialchars($topic['subject'])?></td>
					<td class="col3"><?php echo htmlspecialchars($topic['author'])?></td>
					<td class="col3"><?php echo htmlspecialchars($topic['num_replies'])?></td>
					<td class="col3"><?php echo htmlspecialchars($topic['last_poster'])?></td>
					<td class="col3"><?php echo htmlspecialchars($topic['last_post_time'])?></td>				
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>	
	</div>	
	<div class="pagenum">

			<?php
				paginate("view-forum.php?id=" . $forum_id,$cur_page,1+$forum_info['num_posts']/$limit);
			?>
	</div>
	<?php } else {?>
		<p class="warning">Empty.</p>
	<?php } ?>
	<div class="post">
		<table>
			<tr><th>Create New Topic</th></tr>
			<tr><td>

			<form action="add_topic.php" method="post">	
				<?php if(empty($user_id)) {	?>
					<p class="subject-line"><label>Author name: </label><input type="text" name="name" /></p>
				<?php } ?>
				<p class="subject-line"><label>Subject: </label><input type="text" name="subject" size="128"/></p>
				<textarea name="message" rows="10" cols="128"></textarea>	
				<input type="hidden" name="id" value="<?php echo $forum_id;?>"/>
				<p><input type="submit" /></p>
			</form>

			</td></tr>
		</table>
	</div>
</div>
</div>
</body>
</html>