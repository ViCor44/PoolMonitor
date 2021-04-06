#include <ModbusMaster.h>
#include <Ethernet.h>
#include <SPI.h>
#include <avr/pgmspace.h>

#define MAX485_RE_NEG 3
#define MAX485_DE 2
#define ALARMPIN 22

unsigned long lastCalibrationInterval = 0;
#define CALIBRATION_INTERVAL 10000

/***** Configurações Ethernet *****/
byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xFF };
IPAddress ip(191,188,127, 13);
EthernetServer server(80);

/***** Variaveis a obter *****/
float freeChlorine;
float pH;
float temperature;
int alarm;


ModbusMaster node;

void preTransmission() {
    digitalWrite(MAX485_RE_NEG, 1);
    digitalWrite(MAX485_DE, 1);
}

void postTransmission() {
    digitalWrite(MAX485_RE_NEG, 0);
    digitalWrite(MAX485_DE, 0);
}

// Header 200 OK para XML
void HtmlHeaderOK_XML(EthernetClient client) {    
    client.println("HTTP/1.1 200 OK");
    client.println("Content-Type: text/xml");
    client.println("Connection: keep-alive"); 
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
    client.print("Piscina Activa"); 
    client.print("</poolName>");    
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

void Calibration(){
    Serial.println("*******Calibração*******");
    Serial.print("Valor na saida analógica 0: "); 
    Serial.println(analogRead(0));
    Serial.print("Valor a ser apresentado: "); 
    Serial.println(freeChlorine);
    Serial.println();
    Serial.print("Valor na saida analógica 1: "); 
    Serial.println(analogRead(1));
    Serial.print("Valor a ser apresentado: "); 
    Serial.println(pH);
    Serial.println();
    Serial.print("Valor na saida analógica 2: "); 
    Serial.println(analogRead(2));
    Serial.print("Valor a ser apresentado: "); 
    Serial.println(temperature);    
    Serial.println("************************");     
  }

float modbusResponce(int addr) {

    char serial[20];
    float finalresult;
    float aux;  
    finalresult = node.readInputRegisters(addr,4); // register adress, quantity


    if (finalresult == node.ku8MBSuccess) {
        //Serial.println("\nSerial Number: ");
        int dat=node.getResponseBuffer(0); 
        int dat1=node.getResponseBuffer(1);
        
           
        Serial.println(dat);
        Serial.println(dat1); 
                
        serial[0] = highByte(dat);
        serial[1] = lowByte(dat);
        serial[2] = highByte(dat1);
        serial[3] = lowByte(dat1);
        
        Serial.println("--------------");        
        Serial.print (serial[0]); 
        Serial.print (serial[1]);
        Serial.print (serial[2]); 
        Serial.print (serial[3]);        
        Serial.println("----------------");        

        /* converter as leituras de registos para float */
        union modbus {
          byte t[4];
          float tval;
        } modbusData;

        modbusData.t[0] = lowByte(dat1);
        modbusData.t[1] = highByte(dat1);
        modbusData.t[2] = lowByte(dat);
        modbusData.t[3] = highByte(dat);

        aux = modbusData.tval;
        
        /******************************/
        delay(100);
    }
    else {
        Serial.print("\nError ");
        delay(100);
    }

    return aux;
}

void setup() {
    pinMode(MAX485_RE_NEG, OUTPUT);
    pinMode(MAX485_DE, OUTPUT);
    digitalWrite(MAX485_RE_NEG, 0);
    digitalWrite(MAX485_DE, 0);

    Serial.begin(38400, SERIAL_8O1);
    node.begin(1, Serial);

    node.preTransmission(preTransmission);
    node.postTransmission(postTransmission);

    pinMode(10, OUTPUT);          
    digitalWrite(10, HIGH);       

    //Inicialização dos pins de alarme
    pinMode(ALARMPIN, INPUT); 
    digitalWrite(ALARMPIN, HIGH);     
    
    // Inicialização de Ethernet
    Ethernet.begin(mac, ip);    
    server.begin();
}

void loop() {

    freeChlorine = modbusResponce(130);    
    pH = modbusResponce(138);
    temperature = modbusResponce(146);
    alarm = digitalRead(ALARMPIN);

    Serial.println("");
    Serial.print("Cloro: ");        
    Serial.println (freeChlorine); 
    Serial.print("pH: ");        
    Serial.println (pH);  
    Serial.print("Temperatura: ");        
    Serial.println (temperature);        
    Serial.println("");

    Connection();       
    delay(1000);
}
