// Biblioteca LCD
#include <LiquidCrystal.h>

// Biblioteca de math
#include <math.h>

// Inicializa a biblioteca LCD
LiquidCrystal LCD(12,11,5,4,3,2);

// Define o pino analogico A0 como entrada do Sensor de Temperatura
int SensorTempPino=0;
int SensorTempPino1=1;
int SensorTempPino2=2;
int SensorTempPino3=3;

int i = 1;


void setup() {
	// Define a quantidade de colunas e linhas do LCD
	LCD.begin(16,2);
	// Imprime a mensagem no LCD
	LCD.setCursor(0,0);
	// Imprime a mensagem no LCD
	LCD.print("     %      mmHg");
  	Serial.begin(9600);
	// Muda o cursor para a primeira coluna e segunda linha do LCD
	LCD.setCursor(0,1);
	// Imprime a mensagem no LCD
	LCD.print("   bpm      C");
  	Serial.begin(9600);
}

void loop() {
	// Faz a leitura da tensao no Sensor de Temperatura
	int SensorTempTensao=analogRead(SensorTempPino);
	int SensorTempTensao1=analogRead(SensorTempPino1);
  	int SensorTempTensao2=analogRead(SensorTempPino2);
	int SensorTempTensao3=analogRead(SensorTempPino3);

  	// Converte a tensao lida
	float Tensao=SensorTempTensao*5;
	Tensao/=1024;
      
  	float Tensao1=SensorTempTensao1*5;
	Tensao1/=1024;
  
	float Tensao2=SensorTempTensao2*5;
	Tensao2/=1024;
  
  	float Tensao3=SensorTempTensao3*5;
	Tensao3/=1024;
  	// Converte a tensao lida em Graus Celsius
	float Oxigenacao=		(Tensao-0.5)*100;
  	float PressaoArt=		((Tensao1-0.5)*100);
	float RtmCard=		 	((Tensao2-0.5)*100);
	float TemperaturaC=		((Tensao3-0.5)*100);
  	

  	
  	i += 1;//Incrementa a variavel de gerar leituras aleatoria em 1
  	Serial.println("currSRead:");//Identificador de inicio de leitura
  	LCD.setCursor(0,0); // Muda o cursor para a primeira coluna e PRIMEIRA linha do LCD
	LCD.print(93 + fmod(Oxigenacao*i,7));//Oxigenacao
  	Serial.println("Ox:" + String(93 + fmod(Oxigenacao*i,7)));
  
  	LCD.setCursor(7,0);// Muda o cursor para a Oitava coluna e PRIMEIRA linha do LCD
	LCD.print(9 + fmod(PressaoArt*i,7));//Pressao
  	Serial.println("Press:" + String(9 + fmod(PressaoArt*i,7)));

  	// Muda o cursor para a decima coluna e segunda linha do LCD
	LCD.setCursor(0,1);// Muda o cursor para a primeira coluna e SEGUNDA linha do LCD
  	LCD.print((int)(89 + fmod(RtmCard*i,77)));//BPM
  	Serial.println("Rtm:" + String(89 + fmod(RtmCard*i,77)));
  
  	LCD.setCursor(7,1);// Muda o cursor para a Oitava coluna e SEGUNDA linha do LCD
  	LCD.print(32 + fmod(TemperaturaC*i,7));//Temperatura
  	Serial.println("Temp:" + String(32 + fmod(TemperaturaC*i,7)));
	
  	Serial.println("currERead:");//Identificador de fim de leitura



  	// Aguarda 2 segundos
  	delay(2000);
}