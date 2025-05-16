#include <Wire.h>
#include <LiquidCrystal_I2C.h>

// Inicializa la pantalla LCD en la dirección I2C 0x27 (puede variar)
LiquidCrystal_I2C lcd(0x27, 16, 2);

void setup() {
  // Inicia la comunicación con la LCD
  lcd.init();
  
  // Enciende la luz de fondo
  lcd.backlight();

  // Muestra el mensaje en la pantalla
  lcd.setCursor(0, 0); // Coloca el cursor en la primera columna y fila
  lcd.print("Hola"); // Mensaje a mostrar
}

void loop() {
  // El bucle principal puede estar vacío si no necesitas hacer nada más
}
