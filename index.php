<?php
define('FORUM_ROOT', './');
require FORUM_ROOT . 'common.php';

// Get the list of categories/forums
$statement = sql_query(
	'SELECT c.*, f.* FROM forums AS f ' .
	'INNER JOIN categories AS c ON (f.category_id=c.category_id) ' .
	'ORDER BY c.display_order, f.display_order'
);

$forum_list = array();
while ($result = $statement->fetch(PDO::FETCH_ASSOC))
{
	$forum_list[] = $result;
}

// Get the statistics
$statement = sql_query('SELECT SUM(num_topics) AS num_topics, SUM(num_posts) AS num_posts FROM forums');
$result = $statement->fetchAll();
$stats = $result[0];

require_once "header.php"; ?>

<div id="main">
	<div id="content">
		<?php
		$cate_id = -1;
		foreach ($forum_list as $forum) :
			if($cate_id != $forum['category_id']):
				if($cate_id != -1):
					echo "</tbody></table>";
				endif;	?>					
			
				<div class="category">
					<div class="cate_name"><p><?=$forum['category_name']?></p></div>
						<table>
							<tr><th class="th1">Forum Name</th>
							<th class="th2">Content</th>
							<th class="th3">Topics</th>
							<th class="th4">Posts</th></tr>
							<tbody>
							<?php	$cate_id = $forum['category_id'];
			endif; ?>
							<tr>
								<td class="col1"><a href="view-forum.php?id=<?php echo $forum['forum_id'];?>"><?php echo htmlspecialchars($forum['forum_name']); ?></a></td>
								<td class="col2"><?php echo htmlspecialchars($forum['forum_description']); ?></td>
								<td class="col3"><?php echo $forum['num_topics'] ?></td>
								<td class="col4"><?php echo $forum['num_posts'] ?></td>
							</tr>	
							
				</div>
		<?php
		endforeach;
		?>
		</tbody>
		</table>
	</div>
	<!--
	<div class="cate_name"><p>Statistic</p></div>
		<table>
			<tr><th class="th1">Topics</th><th class="th2">Posts</th></tr>
			<tr>
				<td><?php echo $stats['num_topics'];?></td>
				<td><?php echo $stats['num_posts'];?></td>
			</tr>
		</table>-->
</div>
</div>
</body>
</html>
