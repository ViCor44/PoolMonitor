<?php
/*
	Projeto Final LEI
	Ficheiro: unchecked.php
	Autor: Victor Correia
	Descrição: Página de utilizador não verificado
*/ 
    include('functions.php');
    if (!isLoggedIn()) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<style>
		body {
  			background-image: url('Img/background.png');
		}
	</style>
</head>
<body>
	<img class="logo_pag" src="Img/logo.png" >
	<div class="content" style="heigth: 500px; width: 500px">
		<!-- notification message -->
		<h2>Registo Ainda Não Validado!</h2>
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
		<!-- logged in user information -->
		<div class="profile_info">			
			<div>
				<?php  if (isset($_SESSION['user'])) : ?>
					<strong><?php echo $_SESSION['user']['username']; ?></strong>

					<small>
						<i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['userType']); ?>)</i> 
						<br>
						<a href="unchecked.php?logout='1'" style="font-family:arial; color: red;">logout</a>
					</small>

				<?php endif ?>
			</div>
		</div>
	</div>
</body>
</html>