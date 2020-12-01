#include <Arduino.h>
#include <ESP8266HTTPClient.h>
#include <ESP8266WiFi.h>
#include <LiquidCrystal_I2C.h>
#include <Wire.h>

LiquidCrystal_I2C lcd(0x27,16,2);           //declaring LiquidCrystal_I2C object lcd with i2c address of 0x27 and colums of 16 and rows of 2
/**************************************/
const char* ssid = "My SSID";               // name of your wifi ssid
const char* pwd = "My Password";            // password for your wifi
const int buttonPin = D2;                   // this the pin where the interrupt will occur at
const int ledPin = D7;                      // status led pin
const int wifiPin = D6;                     // indication for a successfull wifi connection
byte sensorInterrupt = 0;                   // 0=digital pin 2
//////////////////////////////////////////
float calibrationFactor = 4.5 ;             // calibration factor for our sensor. You have to tune this value properly for a better outcome
volatile byte pulseCount;                   // volatile variable for ISR
float flowRate;
unsigned int flowMilliLitres;
unsigned long totalMilliLitres,tempTotal = 0,tempUpdate = 0;
unsigned long oldTime;

uint8_t count = 0;
/**************************************/
void setup()
{
  Serial.begin(115200);                     // Starting serial port @115200 baud per second
  delay(10);
  Wire.begin(D4,D3);                        // (SDA, SCL) Initializing Inter-Integrated Circuit communication through Wire library
  pinMode(buttonPin, INPUT);
  pinMode(ledPin, OUTPUT);
  pinMode(wifiPin, OUTPUT);
  lcd.init();                               // initializing lcd module using init() method
  lcd.backlight();                          // enabling led backlight
  lcd.setCursor(0,0);                       // setting cursor @(0,0) position it is a 16 columns 2 line display
  delay(1000);
  lcd.print("Connecting To..");
  lcd.setCursor(0,1);
  lcd.print(ssid);
  delay(3000);
  WiFi.begin(ssid,pwd);                      // initializing wifi
  lcd.clear();
  lcd.setCursor(0,0);
  while (WiFi.status() != WL_CONNECTED)      // execution remain capped in this loop until node module connect with the wifi and print a '.' in lcd
  {
    delay(500);
    lcd.print(".");
  }
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("WiFi Connected.");
  digitalWrite(wifiPin, HIGH);
  delay(3000);
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("Water consumed:");
  lcd.setCursor(0,1);
  lcd.print("0 mL");
  delay(1000); 
  pulseCount = 0;
  flowRate = 0.0;
  flowMilliLitres = 0 ;
  totalMilliLitres = 0 ;
  oldTime = 0 ;
  digitalWrite(buttonPin, HIGH);
  attachInterrupt(digitalPinToInterrupt(buttonPin),pulseCounter,RISING);    // starting interrupt @pin(D2) on RISING event and calling ISR pulseCounter 
}

void loop(){
    if(( millis() - oldTime)> 1000)                                         // check if already 1 second is over 
    {
      detachInterrupt(sensorInterrupt);                                     // disable interrupt
      digitalWrite(ledPin, LOW);
      count++;
      flowRate = (( 1000.0 / ( millis() - oldTime)) * pulseCount) / calibrationFactor;
      oldTime = millis();
      flowMilliLitres = (flowRate / 60 ) * 1000 ;
      totalMilliLitres += flowMilliLitres;
      unsigned int frac;
      frac = (flowRate - int(flowRate)) * 10 ;
      pulseCount = 0 ;
      if(tempTotal != totalMilliLitres)
      {
        tempTotal = totalMilliLitres;
        if(tempTotal < 1000)
        {
          lcd.clear();
          lcd.setCursor(0,0);
          lcd.print("Water consumed:");
          lcd.setCursor(0,1);
          lcd.print((String)tempTotal);
          lcd.print(" mL");
        }
        else
        {
          lcd.clear();
          lcd.setCursor(0,0);
          lcd.print("Water consumed:");
          lcd.setCursor(0,1);
          lcd.print((String)(tempTotal/1000));
          lcd.print("L");
        }
        //Serial.println(count);
        if(count > 25 || count < 35)
        {
          HTTPClient http;                                                                    // declaring HTTPClient object http
          String url = "http://192.168.43.199/bengal_hackers/fakewifidata.php?id=354321";     // the url to communicate with server
          url += "&temp=";
          if(tempUpdate != tempTotal)
          {
            unsigned long recentUsage = tempTotal - tempUpdate;
            url += (String)recentUsage;
            Serial.println(recentUsage);
            url+="&area=Haldiram";
            tempUpdate = tempTotal;
            Serial.println(url);
            http.begin(url);                                                                  // begining http object using begin() method with url
            int httpCode = http.GET();                                                        // sending HTTP header, a GET requset to the server with parameter id,area and usage as temp
            if(httpCode > 0)                                                                  // code for respoce handling
            {
              Serial.printf("[HTTP] GET...code: %d\n", httpCode);
              if(httpCode == HTTP_CODE_OK)
              {
                String payload = http.getString();
                Serial.println(payload);
                digitalWrite(ledPin, HIGH);
              }
              else
              {
                Serial.printf("[HTTP] GET... failed, error: %s\n", http.errorToString(httpCode).c_str());
              }
            }
          }
          //digitalWrite(ledPin, HIGH);
          http.end();
          count = 0;
        }
      }
      attachInterrupt(sensorInterrupt,pulseCounter,FALLING);                                 // enabling the interrupt again
    } 
}

ICACHE_RAM_ATTR void pulseCounter() {                                                         // The ISR
    //Increment the pulse counter
    pulseCount ++;
}
