#include <Ethernet.h>
#include <SPI.h>
#include <avr/pgmspace.h>

#define ALARMPIN 22

/***** Configurações Ethernet *****/
byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xF3 };
IPAddress ip(191,188,127,11); //Substituir pelo ip a implementar
EthernetServer server(80);

/***** Variaveis a obter *****/
float freeChlorine;
float pH;
float temperature;
int alarm;

void setup() {
    Serial.begin(9600);  
    pinMode(10, OUTPUT);          
    digitalWrite(10, HIGH);       

    //Inicialização dos pins de alarme
    pinMode(ALARMPIN, INPUT); 
    digitalWrite(ALARMPIN, HIGH);     
    
    // Inicialização de Ethernet
    Ethernet.begin(mac, ip);    
    server.begin();

}

// Header 200 OK para XML
void HtmlHeaderOK_XML(EthernetClient client) {    
    client.println("HTTP/1.1 200 OK");
    client.println("Content-Type: text/xml"); 
    client.println("Access-Control-Allow-Origin: *");   
    client.println("Cache-Control: no-cache");
    client.println("Cache-Control: no-store");
    client.println();
} 

// Header para File Not Found
void HtmlHeader404(EthernetClient client) {
    client.println("HTTP/1.1 404 Not Found");
    client.println("Content-Type: text/html");
    client.println("");
    client.println("<h2>File Not Found!</h2>");    
    client.println();
}

// Função que devolve o conteudo XML
void XML_response(EthernetClient client)
{     
    client.print("<?xml version = \"1.0\" ?>");
    client.print("<inputs>");
    client.print("<poolName>");
    client.print("Pistas Foam"); 
    client.print("</poolName>"); 
    client.print("<poolID>");
    client.print("4"); 
    client.print("</poolID>"); 
    client.print("<freeChlorine>");
    client.print(freeChlorine);
    client.print("</freeChlorine>");
    client.print("<pH>");
    client.print(pH);
    client.print("</pH>");
    client.print("<temperature>");
    client.print(temperature);
    client.print("</temperature>"); 
    client.print("<alarme>");
    client.print(digitalRead(ALARMPIN));
    client.print("</alarme>");  
    client.print("</inputs>");
} 

// Função de conexão Ethernet
#define BUFSIZE 75
void Connection() {
    char clientline[BUFSIZE];
    int index = 0;
     
    EthernetClient client = server.available();
    if (client) {        
        
        index = 0;       
        while (client.connected()) {
            if (client.available()) {
                char c = client.read();               
                if (c != '\n' && c != '\r') {
                    clientline[index] = c;
                    index++;                    
                    if (index >= BUFSIZE)
                        index = BUFSIZE -1;             
                    continue;
                }               
                clientline[index] = 0;           
                
                Serial.println(clientline);
           
               if (strstr(clientline, "ajax_inputs")) {
                    HtmlHeaderOK_XML(client);                    
                    XML_response(client);                    
                }                
                else {
                    // Tudo o resto é um 404
                    HtmlHeader404(client);
                }
                break;
            }
        }
        // Tempo para o Web Browser receber os dados
        delay(1);
        client.stop();
    }
}

void loop() {
  freeChlorine = analogRead(0);
  pH = analogRead(1);
  temperature = analogRead(2);
  alarm = digitalRead(ALARMPIN);
  Serial.println(freeChlorine);
  Serial.println(alarm);
  Connection();
}
