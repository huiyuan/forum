<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Best Day Ever</title>
		<link rel="stylesheet" type="text/css" href="css/mycss.css" />
	</head>
	<body>
	<div id="container">
		<div id="header">   
			<div id="fb-root"></div>
			<script type="text/javascript">
			window.fbAsyncInit = function() {
				FB.init({
					appId      : '181745918606715',
					channelUrl : '//huiyuanniebear.com/channel.html',
					status     : true, 
					cookie     : true,
					xfbml      : true,
					oauth      : true,
				});
				// Additional initialization code such as adding Event Listeners goes here
				FB.getLoginStatus(function(response) {
					if (response.status === 'connected') {
						// connected
					} else if (response.status === 'not_authorized') {
						// not_authorized
						login();
					} else {
						// not_logged_in
						login();
					}
				});			
			};

			// Load the SDK's source Asynchronously
			// Note that the debug version is being actively developed and might 
			// contain some type checks that are overly strict. 
			// Please report such bugs using the bugs tool.
			(function(d, debug){
				var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
				if (d.getElementById(id)) {return;}
				js = d.createElement('script'); js.id = id; js.async = true;
				js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
				ref.parentNode.insertBefore(js, ref);
			}(document, /*debug*/ false));
			
			function login() {
				FB.login(function(response) {
					if (response.authResponse) {
						// connected
						console.log("login");
						testAPI();
					} else {
						console.log("login");
						// cancelled
					}
				});
			}
			function testAPI() {
				console.log('Welcome!  Fetching your information.... ');
				FB.api('/me', function(response) {
					console.log('Good to see you, ' + response.name + '.');
				});
			}	
			</script>
		

<?php	if($user) {		?>
			<div id="logout">
				Welcome, <?=$user_name?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=$logoutUrl?>" >Logout</a></div>
			<div class="fb-login-button" data-show-faces="true" data-width="200" data-max-rows="1"></div>
<?php	}else {		?>
			<div class="fb-login-button">Login with Facebook</div>
<?php	}	?>
</div>
