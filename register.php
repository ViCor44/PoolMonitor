<?php
/*
	Projeto Final LEI
	Ficheiro: register.php
	Autor: Victor Correia
	Descrição: Pagina para novos registos
*/
 include('functions.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>PoolMonitor - Novo Registo</title>
    <link rel="stylesheet" href="css/style.css">	
</head>
<body>
<div class="formhead">
<img class="logo" src="Img/logo.png" >
	<h2>Novo Registo</h2>
</div>
<form method="post" action="register.php">
	<?php echo display_error(); ?>
	<div class="input-group">
		<label>Username</label>
		<input type="text" name="username" value="<?php echo $username; ?>">
	</div>	
	<div class="input-group">
		<label>Password</label>
		<input type="password" name="password_1">
	</div>
	<div class="input-group">
		<label>Confirme password</label>
		<input type="password" name="password_2">
	</div>
	<div class="input-group">
		<button type="submit" class="btn" name="register_btn">Registar</button>
	</div>
	<p style="font-family:arial;">
		Já está registado? <a href="login.php">Sign in</a>
	</p>
</form>
</body>
</html>
