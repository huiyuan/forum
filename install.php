<?php
define('FORUM_ROOT', './');
require FORUM_ROOT . 'common.php';

// Execute the schema file
try
{
	$queries = explode(";\n", trim(file_get_contents(FORUM_ROOT . 'schema.sql')));
	foreach ($queries as $cur_query)
		$dbh->exec($cur_query);
}
catch (PDOException $e)
{
	print "Error!: " . $e->getMessage() . "<br/>";
	exit;
}

echo 'Done!';