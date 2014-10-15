
<?php
session_start();

include_once('php/DBQuery.php');

if(isset($_SESSION['user_id']))
{
	//header('Location: ../index.html');
	session_destroy();
}

if(isset($_POST['log_in']))
{
	$userName = ($_POST['user_name']);
	$password = ($_POST['password']);
	
	$passwordMD5 = md5('d98b05a7c7add6fa22b8de62444da5a5'.$password.'d99947dd2b0329f55babeaa6597fb7c8');
	$passwordMD5 = md5($passwordMD5);
	
	$result = DBQuery::sql("SELECT id, name, last_name FROM user WHERE user_name = '$userName' AND BINARY password = '$passwordMD5'");
	if(count($result) == 1)
	{
		$_SESSION['user_id'] = $result[0]['id'];
		$_SESSION['name'] = $result[0]['name'];
		$_SESSION['last_name'] = $result[0]['last_name'];
		//Change to hardcoded url later to get rid of index.php in url
		?>
		<script>
			window.location = "index.php?page=start";
		</script>
		<?php
	}
}

?>
<!doctype html>
<html lang="sv-SE">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Trappans personalportal</title>
<link rel="stylesheet" href="css/login.css">
<link href="css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
	<div class="login-container">
		<div class="top-border">
			<div class="color first"></div>
			<div class="color third"></div>
		</div>
		<div class="logotype"></div>
				  <form action="" method="post">
					<label for="user_name">Användarnamn</label>
						<input type="text" id="user_name" name="user_name"> 
					<label for="password">Lösenord</label>
					   	<input type="password" id="password" name="password">
					  	<button class="login-btn primary" type="submit" name="log_in"><span class="fa fa-sign-in fa-2x"></span></button>
				  </form>
		<p class="info">
			För att logga in måste du vara registrerad i systemet. Om du är personal och har problem med att logga in, kontakta webbansvarig eller din lagansvarig. 
		</p>
		
	</div> <!-- #login-container -->
</body>
</html>