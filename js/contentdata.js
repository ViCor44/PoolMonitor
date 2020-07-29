
var contentData = {
	"Visão Global":" ",
	"Configurações":"<li class=\"product\"><div class=\"foodicon foodicon--grain\"></div></li><li class=\"product\"><div class=\"foodicon foodicon--grain\"></div></li><li class=\"product\"><div class=\"foodicon foodicon--grain\"></div></li><li class=\"product\"><div class=\"foodicon foodicon--grain\"></div></li><li class=\"product\"><div class=\"foodicon foodicon--grain\"></div></li><li class=\"product\"><div class=\"foodicon foodicon--grain\"></div></li><li class=\"product\"><div class=\"foodicon foodicon--grain\"></div></li><li class=\"product\"><div class=\"foodicon foodicon--grain\"></div></li><li class=\"product\"><div class=\"foodicon foodicon--grain\"></div></li><li class=\"product\"><div class=\"foodicon foodicon--grain\"></div></li><li class=\"product\"><div class=\"foodicon foodicon--grain\"></div></li><li class=\"product\"><div class=\"foodicon foodicon--grain\"></div></li><li class=\"product\"><div class=\"foodicon foodicon--grain\"></div></li><li class=\"product\"><div class=\"foodicon foodicon--grain\"></div></li><li class=\"product\"><div class=\"foodicon foodicon--grain\"></div></li><li class=\"product\"><div class=\"foodicon foodicon--grain\"></div></li><li class=\"product\"><div class=\"foodicon foodicon--grain\"></div></li><li class=\"product\"><div class=\"foodicon foodicon--grain\"></div></li><li class=\"product\"><div class=\"foodicon foodicon--grain\"></div></li><li class=\"product\"><div class=\"foodicon foodicon--grain\"></div></li><li class=\"product\"><div class=\"foodicon foodicon--grain\"></div></li><li class=\"product\"><div class=\"foodicon foodicon--grain\"></div></li><li class=\"product\"><div class=\"foodicon foodicon--grain\"></div></li><li class=\"product\"><div class=\"foodicon foodicon--grain\"></div></li>",
	"Criar Utilizador":"<h1>Criar Utilizador</h1><iframe frameBorder=\"0\" scrolling=\"no\" src=\"create_user.php\" width=\"500\" height=\"450\"></iframe>",
	"Listar Utilizadores":"<h1>Listar Utilizadores</h1><iframe frameBorder=\"0\" scrolling=\"no\" src=\"users_table.php\" width=\"1200\" height=\"450\"></iframe>",
	"Listar IPs":"<h1>Listar IPs</h1><iframe frameBorder=\"0\" scrolling=\"no\" src=\"ip_table.php\" width=\"1200\" height=\"450\"></iframe>",
	"Listar Piscinas":"<h1>Listar Piscinas</h1><iframe frameBorder=\"0\" scrolling=\"no\" src=\"pools_table.php\" width=\"1200\" height=\"450\"></iframe>",
	"Configurar IP":"<h1>Configurar IP</h1><iframe frameBorder=\"0\" scrolling=\"no\" src=\"IP_config.php\" width=\"500\" height=\"450\"></iframe>",
	"Configurar Piscina":"<h1>Configurar Piscina</h1><iframe frameBorder=\"0\" scrolling=\"no\" src=\"pool_config.php\" width=\"500\" height=\"450\"></iframe>",
	"Remover IP":"<h1>Remover IP</h1><iframe frameBorder=\"0\" scrolling=\"no\" src=\"ip_remove.php\" width=\"500\" height=\"450\"></iframe>",
	"Remover Utilizador":"<h1>Remover Utilizador</h1><iframe frameBorder=\"0\" scrolling=\"no\" src=\"user_remove.php\" width=\"500\" height=\"450\"></iframe>",
	"Remover Piscina":"<h1>Remover Piscina</h1><iframe frameBorder=\"0\" scrolling=\"no\" src=\"pool_remove.php\" width=\"500\" height=\"450\"></iframe>",
	"Conceder Permissão":"<h1>Conceder Permissão</h1><iframe frameBorder=\"0\" scrolling=\"no\" src=\"user_permission.php\" width=\"500\" height=\"450\"></iframe>",

}



function openDetails(){
	var popup = window.open('details.php','window','toolbar=no, location=no, fullscreen=yes, titlebar=no, menubar=no, resizable=no');
  	if (popup.outerWidth < screen.availWidth || popup.outerHeight < screen.availHeight)
  	{
  		popup.moveTo(0,0);
  		popup.resizeTo(screen.availWidth, screen.availHeight);
	}
}

function callArduino(){
	var IPdata = [];
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			IPdata = JSON.parse(this.responseText);						
		}
	};
	xmlhttp.open("GET", "ip_table_db.php", true);
	xmlhttp.send();
	setTimeout(function() {
		for (i = 0; i < IPdata.length; i++){
			GetArduinoInputs("http://" + IPdata[i].ip + "/ajax_inputs", true, i+1);
		}	}, 700);
	
}

var interval;

function showContent(itemName){		
	if(!interval){
		interval = setInterval(callArduino, 2000);
	}	
	var gridWrapper = document.querySelector('.content');
	switch (itemName){
		case 'Criar Utilizador':
			clearInterval(interval);
			interval = 0;
			gridWrapper.innerHTML = '<ul class="products">' + contentData[itemName] + '<ul>';
			break;
	
		case 'Listar Utilizadores':
			clearInterval(interval);
			interval = 0;
			gridWrapper.innerHTML = '<ul class="products">' + contentData[itemName] + '<ul>';
			break;
		case 'Listar IPs':
			clearInterval(interval);
			interval = 0;
			gridWrapper.innerHTML = '<ul class="products">' + contentData[itemName] + '<ul>';
			break;
		case 'Listar Piscinas':
			clearInterval(interval);
			interval = 0;
			gridWrapper.innerHTML = '<ul class="products">' + contentData[itemName] + '<ul>';
			break;
		case 'Configurar IP':
			clearInterval(interval);
			interval = 0;
			gridWrapper.innerHTML = '<ul class="products">' + contentData[itemName] + '<ul>';
			break;
		case 'Remover IP':
			clearInterval(interval);
			interval = 0;
			gridWrapper.innerHTML = '<ul class="products">' + contentData[itemName] + '<ul>';
			break;
		case 'Configurar Piscina':
			clearInterval(interval);
			interval = 0;
			gridWrapper.innerHTML = '<ul class="products">' + contentData[itemName] + '<ul>';
			break;
		case 'Remover Utilizador':
			clearInterval(interval);
			interval = 0;
			gridWrapper.innerHTML = '<ul class="products">' + contentData[itemName] + '<ul>';
			break;	
		case 'Remover Piscina':
			clearInterval(interval);
			interval = 0;
			gridWrapper.innerHTML = '<ul class="products">' + contentData[itemName] + '<ul>';
			break;
		case 'Conceder Permissão':
			clearInterval(interval);
			interval = 0;
			gridWrapper.innerHTML = '<ul class="products">' + contentData[itemName] + '<ul>';
			break;		

		case 'Visão Global':				
		var ipLen;
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				ipLen = JSON.parse(this.responseText);						
			}
		};
		xmlhttp.open("GET", "ip_table_db.php", true);
		xmlhttp.send();		
		classie.add(gridWrapper, 'content--loading');
		
		setTimeout(function() {	
						
			classie.remove(gridWrapper, 'content--loading');				
			sleep(1500);			
		}, 700);		
				
		var codeBlockOne;
		var codeBlockTwo = "";
		var codeBlockThree;
		var result;			
				
		setTimeout(function() {
			codeBlockOne = '<ul class="products">' +
								'<h1>Visão Global</h1>';

			for (i = 1; i <= ipLen.length; i++){
				
				codeBlockTwo += 	'<div id="bx' + i + '" style="display: none" class="element element-1" >' +
									'<span class="tooltiptext">Clique para detalhes</span>' +							
									'<p><span class="poolName" id="input4-' + i + '" onclick="callDetails(' + i + ')">'+ ipLen[i-1].name +'</span></p>' +
									'<p id="cloro-' + i + '">Cloro Livre:  <span id="input1-' + i + '">...</span></p>'+
									'<p id="ph-' + i + '">pH:     <span id="input2-' + i + '">...</span></p>' +
									'<p id="temp-' + i + '">Temperatura: <span id="input3-' + i + '">...</span></p>' +
									'<span id="input5-' + i + '">' +
										'<img src="Img/alarm.gif" class="danger">' +
										'<p id="bad-con">Verifique controlador!</p>' +
									'</span>' +
									'<span id="input6-' + i + '">' +
										'<img src="Img/disconnect.png" class="danger">' +
										'<p id="bad-con">Verifique ligação!</p>' +
									'</span>' +
								'</div>';				
				
			}
			codeBlockThree = '</ul>';
			result = codeBlockOne + codeBlockTwo + codeBlockThree;
			gridWrapper.innerHTML = result;
			for (i = 1; i <= ipLen.length; i++){
				var x = document.getElementById("bx" + i);
				x.style.display = "block";
			}
		}, 700); 		
	}
}

function callDetails(option) {
	option = option - 1;
	var IPdata = [];
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			IPdata = JSON.parse(this.responseText);						
		}
	};
	xmlhttp.open("GET", "ip_table_db.php", true);
	xmlhttp.send();
	
	setTimeout(function() {		
	
	$.ajax({
		 type: "POST",
		 url: 'details.php',
		 data: {
			txt: IPdata[option].name,
			ip: IPdata[option].ip
        },
        dataType : 'json',
		 success:function() {
		 }
	});
	var popup = window.open('details.php','window','toolbar=no, location=no, fullscreen=yes, titlebar=no, menubar=no, resizable=no');
	if (popup.outerWidth < screen.availWidth || popup.outerHeight < screen.availHeight)	{
		popup.moveTo(0,0);
		popup.resizeTo(screen.availWidth, screen.availHeight);
 	}
}, 700);
	
}

function sleep(milliseconds) {
	const date = Date.now();
	let currentDate = null;
	do {
	  currentDate = Date.now();
	} while (currentDate - date < milliseconds);
  }