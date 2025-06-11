# Usa un entorno de ejecución oficial de Node.js como imagen base
FROM node:18-alpine

# Establece el directorio de trabajo dentro del contenedor
# Todos los comandos subsiguientes se ejecutarán desde /app dentro del contenedor.
WORKDIR /app

# Copia todo el contenido del directorio actual de tu repositorio (la raíz donde está el Dockerfile)
# al directorio /app dentro del contenedor.
COPY . .

# Instala las dependencias de Node.js
# Esto asume que tu package.json ahora está en /app/package.json
RUN npm install

# Expone el puerto en el que escucha tu aplicación
# Render detectará automáticamente este puerto o puedes configurarlo en sus settings.
EXPOSE 3000

# Define el comando para ejecutar tu aplicación cuando el contenedor se inicie.
# Esto asume que tu archivo principal del servidor es 'server.js' en la raíz.
CMD [ "node", "server.js" ]
