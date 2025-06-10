# Use an official Node.js runtime as a parent image
FROM node:18-alpine

# Set the working directory in the container
WORKDIR /app

# Copy package.json and package-lock.json from the 'client' directory to the working directory
COPY client/package*.json ./

# Install any dependencies
RUN npm install

# Copy the rest of the application code (including the 'client' directory)
COPY . .

# Expose port 3000 (adjust if your app listens on a different port)
EXPOSE 3000

# Define the command to run your application (adjust the path if needed)
CMD [ "node", "client/server.js" ]
