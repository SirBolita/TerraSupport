#include <WiFi.h>
#include <HTTPClient.h>
#include "DHTesp.h"

int pinPulsador = 13;
int pinLed = 12;
int estadoAnterior = LOW;
int estadoActual = LOW;

const char* ssid = "S21_Ultra";
const char* password = "123456789";
const char* serverUrl = "https://conocetutierra.000webhostapp.com/insertar.php";

int t;
int h;
int l;
int p = 5;

int ldr = analogRead(32);;
int maxldr = 4095;
int minldr = 0;

int pinDHT = 14;

DHTesp dht;

void setup() {

  Serial.begin(115200);
  delay(4000);
  
  pinMode(pinPulsador, INPUT);
  pinMode(pinLed, OUTPUT);
  
  dht.setup(pinDHT, DHTesp::DHT11);

  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Conectando a WiFi...");
  }

  Serial.println("Conectado a WiFi");
}

void loop() {
  estadoActual = digitalRead(pinPulsador);

  if (estadoActual != estadoAnterior && estadoActual == HIGH) {
    digitalWrite(pinLed, !digitalRead(pinLed)); // Cambia el estado del LED

    TempAndHumidity data = dht.getTempAndHumidity();

    t = data.temperature;
    h = data.humidity;
    l = map(ldr, minldr, maxldr, 1000, 0);

    Serial.println("-------------------------------");
    Serial.print("Temperatura: ");
    Serial.print(t);
    Serial.println("°C");
    Serial.print("Humedad: ");
    Serial.print(h);
    Serial.println("%");
    Serial.print("Luz: ");
    Serial.print(l);
    Serial.println(" Lm");
    Serial.print("Ph: ");
    Serial.println(p);
    Serial.println("-------------------------------");
    delay(2000);
  
    HTTPClient http;
    http.begin(serverUrl);
  
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  
    String postData = "temperatura=" + String(t) + "&humedad=" + String(h) + "&luz=" + String(l) + "&ph=" + String(p);
  
    int httpResponseCode = http.POST(postData);
  
    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println("Código de respuesta HTTP: " + String(httpResponseCode));
      Serial.println(response);
    } else {
      Serial.println("Error en la solicitud HTTP");
    }
  
    http.end();

    estadoActual = LOW;
    digitalWrite(pinLed, LOW);
    Serial.println("-------------------------------");
  }
  
  estadoAnterior = estadoActual;
}