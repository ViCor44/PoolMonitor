function GetArduinoInputs(ip, sinc, elem)
{
    var alarme;
    nocache = "&nocache=" + Math.random() * 1000000;
    var request = new XMLHttpRequest();
    var dataReq = [0, 0, 0, 0];
    request.onreadystatechange = function()
    {
        if (this.readyState == 4) {
            if (this.status == 200) {
                if (this.responseXML != null && sinc == true) {
                    // extract XML data from XML file
                    var y = document.getElementById("input1-" + elem);
                    y.innerHTML = this.responseXML.getElementsByTagName('freeChlorine')[0].childNodes[0].nodeValue;
                    document.getElementById("input2-" + elem).innerHTML =
                        this.responseXML.getElementsByTagName('pH')[0].childNodes[0].nodeValue;
                    document.getElementById("input3-" + elem).innerHTML =
                        this.responseXML.getElementsByTagName('temperature')[0].childNodes[0].nodeValue;
                    document.getElementById("input4-" + elem).innerHTML =
                        this.responseXML.getElementsByTagName('poolName')[0].childNodes[0].nodeValue;
                    document.getElementById("input4-" + elem).style.color = "white";
                    alarme =  this.responseXML.getElementsByTagName('alarme')[0].childNodes[0].nodeValue;  
                    if (alarme == 1) {
                        var x = document.getElementById("input5-" + elem);
                        x.style.display = "none";
                    } else {
                        var x = document.getElementById("input5-" + elem);
                        x.style.display = "block";
                    }                       
                }
                if (this.responseXML != null && sinc == false) {
                    dataReq[0] = this.responseXML.getElementsByTagName('freeChlorine')[0].childNodes[0].nodeValue;
                    dataReq[1] = this.responseXML.getElementsByTagName('pH')[0].childNodes[0].nodeValue;
                    dataReq[2] = this.responseXML.getElementsByTagName('temperature')[0].childNodes[0].nodeValue;
                    dataReq[3] = this.responseXML.getElementsByTagName('alarme')[0].childNodes[0].nodeValue; 
                }                           
                    
            } else {
                document.getElementById("input1-" + elem).innerHTML = "...";                            
                document.getElementById("input2-" + elem).innerHTML = "...";                            
                document.getElementById("input3-" + elem).innerHTML = "...";                                                  
                document.getElementById("input4-" + elem).innerHTML = "Erro de ligação"; 
                document.getElementById("input4-" + elem).style.color = "red"; 
                var x = document.getElementById("input5-" + elem);
                x.style.display = "none";                          
            }
        }
    }
    request.open("GET", ip + nocache, sinc);
    request.send(null); 

    return dataReq;
}
        
