<?php
/*
	Projeto Final LEI
	Ficheiro: login.php
	Autor: Victor Correia
	Descrição: Página de Login
*/
include('functions.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>PoolMonitor Login</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">	
</head>
<body>
	<div class="formhead">
	<img class="logo" src="Img/logo.png" >
		<h2>Login</h2>
	</div>	
	<form method="post" action="login.php" autocomplete="off">

		<?php echo display_error(); ?>

		<div class="input-group">
			<label>Username</label>
			<input type="text" name="username" autofocus>
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type="password" name="password">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="login_btn">Login</button>
		</div>		
		<p style="font-family:arial;">
			Sem registo ainda? <a href="register.php">Novo Registo</a>
		</p>
	</form>
</body>
</html>