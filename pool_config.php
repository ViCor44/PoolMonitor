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
	<form class="new-user" method="post" action="pool_config.php">

		<?php echo display_error(); ?>

		<div class="input-group">
			<label>Designação</label>
			<input type="text" name="poolName" value=" ">
		</div>		
		
		<div class="input-group">
			<button type="submit" class="btn" name="pool_register_btn"> Submeter</button>
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