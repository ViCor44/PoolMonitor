<?php 
/*
	Projeto Final LEI
	Ficheiro: admin.php
	Autor: Victor Correia
	Descrição: Página de entrada para um utilizador normal
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
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title></title>	
	<link rel="shortcut icon" href="favicon.ico">	
	<link rel="stylesheet" type="text/css" href="css/style.css" />		
	<link rel="stylesheet" type="text/css" href="css/component.css" />
	<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="js/modernizr-custom.js"></script>
</head>

<body>
	<div class="container">
		<header class="bp-header cf">
			<div class="dummy-logo">
				<img class="fit-logo" src="img/logo.png">				
			</div>
			<div class="bp-header__main">						
				<?php  if (isset($_SESSION['user'])) : ?>
					<strong style="font-family:arial;"><?php echo $_SESSION['user']['username']; ?></strong>
					
						<i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['userType']); ?>)</i> 
						<br>
						<a style="font-family:arial;" href="admin.php?logout='1'" style="color: red;">logout</a>
					
				<?php endif ?>			
			</div>
		</header>
		<button class="action action--open" aria-label="Open Menu"><span class="icon icon--menu"></span></button>
		<nav id="ml-menu" class="menu">
			<button class="action action--close" aria-label="Close Menu"><span class="icon icon--cross"></span></button>
			<div class="menu__wrap">
				<ul data-menu="main" class="menu__level" tabindex="-1" role="menu" aria-label="All">
					<li class="menu__item" role="menuitem"><a class="menu__link" data-submenu="submenu-1" aria-owns="submenu-1" href="#">Visão Global</a></li>
					<li class="menu__item" role="menuitem"><a class="menu__link" data-submenu="submenu-2" aria-owns="submenu-2" href="#">Listagens</a></li>
				</ul>
				<!-- Submenu 2 -->
				<ul data-menu="submenu-2" class="menu__level">
					<li class="menu__item"><a class="menu__link" href="#">Listar IPs</a></li>
					<li class="menu__item"><a class="menu__link" href="#">Listar Piscinas</a></li>					
				</ul>
			</div>
		</nav>
		<div class="content">
			<p class="info">Escolha uma categoria</p>
		</div>
	</div>
	<script src="js/classie.js"></script>
	<script src="js/contentdata.js"></script>
	<script src="js/main.js"></script>
	<script src="js/request.js"></script>
	<script>
	(function() {
		var menuEl = document.getElementById('ml-menu'),
			mlmenu = new MLMenu(menuEl, {
				backCtrl : false, 
				onItemClick: loadContentData 
			});

		// mobile menu toggle
		var openMenuCtrl = document.querySelector('.action--open'),
			closeMenuCtrl = document.querySelector('.action--close');

		openMenuCtrl.addEventListener('click', openMenu);
		closeMenuCtrl.addEventListener('click', closeMenu);

		function openMenu() {
			classie.add(menuEl, 'menu--open');
			closeMenuCtrl.focus();
		}

		function closeMenu() {
			classie.remove(menuEl, 'menu--open');
			openMenuCtrl.focus();
		}

		var gridWrapper = document.querySelector('.content');

		function loadContentData(ev, itemName) {				
			ev.preventDefault();
			closeMenu();
			gridWrapper.innerHTML = '';
			classie.add(gridWrapper, 'content--loading');
			setTimeout(function() {				
				classie.remove(gridWrapper, 'content--loading');				
				showContent(itemName);			
			}, 700);
			var i;			
		}
	})();
	</script>
</body>

</html>
