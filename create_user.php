<?php
/*
	Projeto Final LEI
	Ficheiro: create_user.php
	Autor: Victor Correia
	Descrição: Criação de novo utilizador por administrador
*/
include('functions.php');

if (!isAdmin()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: login.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>PoolMonitor - Criar Utilizador</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">			
</head>
<body style="background: rgb(255, 255, 255, 0)">		
	<form class="new-user" method="post" action="create_user.php">

		<?php echo display_error(); ?>

		<div class="input-group">
			<label>Utilizador</label>
			<input type="text" name="username" value="<?php echo $username; ?>">
		</div>		
		<div class="input-group">
			<label>Tipo de Utilizador</label>
			<select name="user_type" id="user_type" >
				<option value=""></option>
				<option value="admin">Admin</option>
				<option value="user">User</option>
			</select>
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type="password" name="password_1">
		</div>
		<div class="input-group">
			<label>Confirmar password</label>
			<input type="password" name="password_2">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="admin_register_btn"> + Criar utilizador</button>
			<?php if (isset($_SESSION['success'])) : ?>
				<div class="error success" >
					<h3>
						<?php 
							echo $_SESSION['success']; 
							unset($_SESSION['success']);
						?>
					</h3>
				</div>
			<?php endif ?>
		</div>
	</form>	
	</div>
</body>
</html>