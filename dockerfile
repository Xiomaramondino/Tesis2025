# Usa un entorno de ejecución oficial de Node.js como imagen base
FROM node:18-alpine

# Establece el directorio de trabajo dentro del contenedor
WORKDIR /app

# Copia todo el contenido del directorio actual de tu repositorio (la raíz)
# al directorio /app dentro del contenedor.
COPY . .

# Instala las dependencias de Node.js
RUN npm install

# Expone el puerto en el que escucha tu aplicación
EXPOSE 3000

# Define el comando para ejecutar tu aplicación cuando el contenedor se inicie.
# ¡IMPORTANTE!: Reemplaza 'TU_ARCHIVO_PRINCIPAL.js' con el nombre exacto y ruta si está en subcarpeta.
# Ejemplos:
# Si tu archivo se llama 'app.js' y está en la raíz: CMD [ "node", "app.js" ]
# Si tu archivo se llama 'index.js' y está en la carpeta 'src': CMD [ "node", "src/index.js" ]
CMD [ "node", "TU_ARCHIVO_PRINCIPAL.js" ]
