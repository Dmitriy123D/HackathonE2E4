<!DOCTYPE html>
<?php

	if (!empty($_COOKIE['sid'])) {
		// check session id in cookies
		session_id($_COOKIE['sid']);
	}

	session_start();
	require_once 'classes/Auth.class.php';

	require_once ("config.php");
	require_once ("preheader.php");
?>

<html lang="ru">
<head>
	<meta charset="utf-8">
	<title>Your page title here :)</title>
	<meta name="description" content="">
	<meta name="author" content="">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600,700i,900&display=swap&subset=cyrillic" rel="stylesheet">

	<!-- CSS –––––––––––––––––––––––––––––––––––– -->

	<link rel="stylesheet" href="css/less/theme.css">

	<link rel="icon" type="image/png" href="images/favicon.png">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script src="./js/ajax-form.js"></script>
</head>

<body>

	<?php if (Auth\User::isAuthorized()): ?>

	<form class="ajax" method="post" action="./ajax.php" style="display: none;">
	  <input type="hidden" name="act" value="logout">
	  <div class="form-actions">
	      <button class="btn btn-large btn-primary" type="submit">Logout</button>
	  </div>
	</form>

	<div class="frontpage"> 
		<div class="container">
			<h1 class="title">Мы поможем вам<br>стать <span>здоровыми</span></h1>
			<div class="">
				<?php require_once ("body.php");?>
			</div>
		</div>
	</div>

	<?php else: ?>

	  <form class="form-signin ajax" method="post" action="./ajax.php">
		<div class="main-error alert alert-error hide"></div>

		<h2 class="form-signin-heading">Please sign in</h2>

		<input name="username" type="text" class="input-block-level" placeholder="Username" autofocus>
		<input name="password" type="password" class="input-block-level" placeholder="Password">
		<label class="checkbox">
		  <input name="remember-me" type="checkbox" value="remember-me" checked> Remember me
		</label>
		<input type="hidden" name="act" value="login">
		<button class="btn btn-large btn-primary" type="submit">Sign in</button>

		<div class="alert alert-info" style="margin-top:15px;">
			<p>Not have an account? <a href="/register.php">Register it.</a>
		</div>
	  </form>

	<?php endif; ?>

</body>
</html>