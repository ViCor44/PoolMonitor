/*
	Projeto Final LEI
	Ficheiro: request.js
	Autor: Victor Correia
	Descrição: Script para adquirir informação dos Arduinos
*/
function GetArduinoInputs(ip, sinc, elem)
{
    var alarme;
    var cloroLivre;
    var pH;
    var temp;
    nocache = "&nocache=" + Math.random() * 1000000;
    var request = new XMLHttpRequest();
    var dataReq = [0, 0, 0, 0];
    request.onreadystatechange = function()
    {
        if (this.readyState == 4) {
            if (this.status == 200) {
                if (this.responseXML != null && sinc == true) {
                    // extract XML data from XML file
                    cloroLivre = document.getElementById("input1-" + elem);
                    cloroLivre.innerHTML = this.responseXML.getElementsByTagName('freeChlorine')[0].childNodes[0].nodeValue;
                    
                    if (cloroLivre.innerHTML >= 3.00 || cloroLivre.innerHTML <= 0.60){
                        document.getElementById("input1-" + elem).style.backgroundColor = "red";
                        document.getElementById("input1-" + elem).style.color = "white";
						document.getElementById("input1-" + elem).style.cursor = "pointer";
						if(cloroLivre.innerHTML >= 3.00){
							document.getElementById("input1-" + elem).addEventListener("click", chlorineHigh);
						}
						if(cloroLivre.innerHTML <= 0.60){
							document.getElementById("input1-" + elem).addEventListener("click", chlorineLow);
						}

                    }
                    else {
                        document.getElementById("input1-" + elem).style.backgroundColor = "transparent";
                        document.getElementById("input1-" + elem).style.color = "black";

                    }

                    pH = document.getElementById("input2-" + elem);
                    pH.innerHTML = this.responseXML.getElementsByTagName('pH')[0].childNodes[0].nodeValue;

                    if (pH.innerHTML >= 7.80 || pH.innerHTML <= 7.00){
                        document.getElementById("input2-" + elem).style.backgroundColor = "red";
                        document.getElementById("input2-" + elem).style.color = "white";
						document.getElementById("input2-" + elem).style.cursor = "pointer";
						if(pH.innerHTML >= 7.80){
							document.getElementById("input2-" + elem).addEventListener("click", pHHigh);
						}
						if(pH.innerHTML <= 7.00){
							document.getElementById("input2-" + elem).addEventListener("click", pHLow);
						}
                    }
                    else {
                        document.getElementById("input2-" + elem).style.backgroundColor = "transparent";
                        document.getElementById("input2-" + elem).style.color = "black";
						document.getElementById("input2-" + elem).style.cursor = "default";
                    }

                    temp = document.getElementById("input3-" + elem);                       
                    temp.innerHTML = this.responseXML.getElementsByTagName('temperature')[0].childNodes[0].nodeValue;
                    document.getElementById("input4-" + elem).style.color = "white";
                    alarme =  this.responseXML.getElementsByTagName('alarme')[0].childNodes[0].nodeValue;
                    document.getElementById("cloro-" + elem).style.display = "block";                          
                    document.getElementById("ph-" + elem).style.display = "block";                           
                    document.getElementById("temp-" + elem).style.display = "block";  
                    document.getElementById("input6-" + elem).style.display = "none";
                    document.getElementById("input7-" + elem).style.display = "none"; 
                    if (alarme == '1') {
                        var x = document.getElementById("input5-" + elem);
                        x.style.display = "none";
                    } else {
                        document.getElementById("cloro-" + elem).style.display = "none";                          
                        document.getElementById("ph-" + elem).style.display = "none";                           
                        document.getElementById("temp-" + elem).style.display = "none"; 
                        document.getElementById("input6-" + elem).style.display = "none";
                        document.getElementById("input7-" + elem).style.display = "none";
                        document.getElementById("input5-" + elem).style.display = "block";                                                  
                        document.getElementById("input4-" + elem).style.color = "red"; 
                    }                       
                }
                if (this.responseXML != null && sinc == false) {
                    dataReq[0] = this.responseXML.getElementsByTagName('freeChlorine')[0].childNodes[0].nodeValue;
                    dataReq[1] = this.responseXML.getElementsByTagName('pH')[0].childNodes[0].nodeValue;
                    dataReq[2] = this.responseXML.getElementsByTagName('temperature')[0].childNodes[0].nodeValue;
                    dataReq[3] = this.responseXML.getElementsByTagName('alarme')[0].childNodes[0].nodeValue; 
                }                           
                    
            } else {
                document.getElementById("cloro-" + elem).style.display = "none";                          
                document.getElementById("ph-" + elem).style.display = "none";                           
                document.getElementById("temp-" + elem).style.display = "none"; 
                document.getElementById("input5-" + elem).style.display = "none";
                document.getElementById("input6-" + elem).style.display = "block"; 
                document.getElementById("input7-" + elem).style.display = "none";                                                 
                document.getElementById("input4-" + elem).style.color = "red"; 
            }
        }
    }
    request.open("GET", ip + nocache, sinc);
    request.send(); 

    return dataReq;
}

function pHHigh(){
	swal("pH demasiado alto!", "1. Verifique nivel de ácido\n2. Verifique calibração do electrodo\n3. Verifique parâmetros do controlador", "error");	
}

function pHLow(){
	swal("pH demasiado baixo!", "1. Dosagem elevada, verifique bomba doseadora \n2. Verifique calibração do electrodo\n3. Verifique parâmetros do controlador", "error");	
}

function chlorineLow(){
	swal("Cloro demasiado baixo!", "1. Controlador em alarme, verifique controlador\n2. Verifique bomba doseadora\n3. Verifique calibração do electrodo", "error");	
}

function chlorineHigh(){
	swal("Cloro demasiado alto!", "1. Dosagem elevada, verifique bomba doseadora \n2. Verifique calibração do electrodo\n3. Verifique parâmetros do controlador", "error");	
}
        
