<?php
/*
	Projeto Final LEI
	Ficheiro: create_user.php
	Autor: Victor Correia
	Descrição: Criação de novo utilizador por administrador
*/
include('functions.php');
include('connection.php');

if (!isAdmin()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: login.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>PoolMonitor - Configurar IP</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">			
</head>
<body style="background: rgb(255, 255, 255, 0)">		
	<form class="new-user" method="post" action="IP_remove.php">

		<?php echo display_error(); ?>				
		<div class="input-group">
			<label>IP</label>
			<select name="ip" id="user_type">
                <?php 
                    $sql = "SELECT * FROM ip_table";
                    $result = $db->query($sql);
					while ($row = $result->fetch_assoc()):;?>

            <option value="<?php echo $row['IP'];?>"><?php echo $row['IP'];?></option>

            <?php endwhile;?>
                
			</select>
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="IP_remove_btn" onclick="return confirm('Quer mesmo remover IP?')"> Remover</button>
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