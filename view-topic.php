<?php
define('FORUM_ROOT', './');
require FORUM_ROOT . 'common.php';

$id = isset($_GET['id'])? trim($_GET['id']): ""; // get topic id

$limit = 25;
$cur_page = isset($_GET['page'])? intval($_GET['page']) : 1;

$statement= sql_query('SELECT DISTINCT * FROM topics INNER JOIN forums ON forums.forum_id = topics.forum_id '.
'INNER JOIN categories ON categories.category_id = forums.category_id WHERE topic_id = ?',array($id));
$result = $statement->fetchAll();
$topic_info = $result[0];	// the original post

$statement = sql_query('SELECT * FROM posts WHERE topic_id =? ORDER BY posted_time ASC LIMIT ' . (($cur_page-1) * 25) . ', 25',array($id));
$post_list = array();
$orig_post = $statement->fetch(PDO::FETCH_ASSOC);	// fetch the first one
while($result = $statement->fetch(PDO::FETCH_ASSOC)){
	$post_list[] = $result;
}
$post_list = array_reverse($post_list, true);

require_once "header.php";
?>

<div id="main">
	<div class="breadcrumb">
		<p><a href="index.php" >HOME</a>
			<a href="index.php">▹<?php echo htmlspecialchars($topic_info['category_name']);?></a>
			<a href="view-forum.php?id=<?php echo $topic_info['forum_id'];?>" >▹<?php echo $topic_info['forum_name'];?></a>
			<a>▹<?php echo $topic_info['subject'];?></a>
		</p>
	</div>
	
	<div>
		<table>
			<tr><th class="th5">Author</th><th class="th6">Content</th><th class="th7">Post Time</th></tr>
			<tbody>
			<tr>
				<td><?php echo htmlspecialchars($orig_post['author']);
						if($orig_post['author_id']) {
										?>
										<p><img src="http://graph.facebook.com/<?=$orig_post['author_id']?>/picture" alt="" ></p>
									<?php
									}
									else {
									?>
										<p><img src="img/Mrm_nobody.jpg" alt="" ></p>
									<?php
									}
									?></td>
				<td><?php echo htmlspecialchars($orig_post['contents']);?></td>
				<td><?php echo htmlspecialchars($orig_post['posted_time']);?></td>
			</tr>
			</tbody>
		</table>
	</div>
	
	<?php if($post_list) : ?>
	<div>
		<p>Replies</p>
		<table>
		<tr><th class="th5">Author</th><th class="th6">Content</th><th class="th7">Post Time</th>
		<tbody>
			<?php
				foreach($post_list as $post): ?>
					<tr>
						<td><?php echo htmlspecialchars($post['author']);?><?php
									if($post['author_id']) {
										?>
										<p><img src="http://graph.facebook.com/<?=$post['author_id']?>/picture" alt="" ></p>
									<?php
									}
									else {
									?>
										<p><img src="img/Mrm_nobody.jpg" alt="" ></p>
									<?php
									}
									?></td>
						<td><?php echo htmlspecialchars($post['contents']);?></td>
						<td><?php echo htmlspecialchars($post['posted_time']);?></td>
					</tr>
			<?php
				endforeach; ?>
		</tbody>
		</table>	
	</div>	
	<div class="pagenum">
			<?php
				paginate("view-topic.php?id=" . $id,$cur_page,1+$topic_info['num_replies']/$limit);
			?>
	</div>
	<?php endif; ?>
	<div class="post">
		<table>
			<tr><th>Create New Post</th></tr>
			<tr><td>

			<form action="add_post.php" method="post">	
			<?php 
			if(empty($user_id)&&empty($user_name)) {	
			?>
				<p class="subject-line"><label>Author Name: </label><input type="text" name="name" /></p>
			<?php
			}
			?>
			<p class="subject-line">Subject : <?php echo htmlspecialchars($topic_info['subject']) ?></p>
			<textarea name="message" rows="10" cols="120"></textarea>	
			<input type="hidden" name="id" value="<?php echo $id;?>"/>
			<input type="hidden" name="forum_id" value="<?php echo $topic_info['forum_id'];?>"/>
			<p><input type="submit" /></p>		
			</form>

			</td></tr>
			</table>
	</div>

</div>
</body>
</html>