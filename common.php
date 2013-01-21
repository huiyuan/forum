<?php
if (!defined('FORUM_ROOT'))
	exit;

// Enable error reporting
error_reporting(E_ALL);

// Try to connect to the database
try
{
	$dbh = new PDO('mysql:host=Bestdayever.db.10129095.hostedresource.com;dbname=Bestdayever', 'Bestdayever', 'Bestdayever11!');
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
	print "Error!: " . $e->getMessage() . "<br/>";
	exit;
}

require_once("../facebook-php-sdk/src/facebook.php");
$user_id = '';
$user_name = ''; 
$facebook = new Facebook(array(
  'appId'  => '550372924991006',
  'secret' => '0992e62ad5e90c2d94007c9131744c2f',
));

// Get User ID
$user = $facebook->getUser();
$access_token = $facebook->getAccessToken();

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
    $user_id = $user_profile['id'];
    $user_name = $user_profile['name'];
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}



function sql_query($sql,$params = array())
{
	global $dbh, $tpl;

	try
	{
		$query = $dbh->prepare($sql);
		$query->execute($params);
	}
	catch (PDOException $e)
	{
		$tpl->assign('error_message', 'Error!: ' . $e->getMessage());
		$tpl->render('error');
		exit;
	}

	return $query;
	}

function paginate($url, $cur_page, $num_pages)
{
	echo '<div class="pages"><ol>';
	for ($i = 1; $i <= $num_pages; ++$i)
	{
		if ($cur_page == $i)
			echo '<li>' . $i . '</li>';
		else
			echo '<li><a href="' . $url . '&amp;p=' . $i . '">' . $i . '</a>';
		
	}
	echo '</ol></div>';
}
?>
