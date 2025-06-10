# Use an official Node.js runtime as a parent image
FROM node:18-alpine

# Set the working directory in the container
WORKDIR /app

# Copy package.json and package-lock.json to the working directory
# IMPORTANT: Adjust this path if package.json is in a subdirectory (e.g., 'client/package*.json')
COPY package*.json ./

# Install any dependencies
RUN npm install

# Copy the rest of the application code
# IMPORTANT: If your main code is in a subdirectory (e.g., 'client/'), you might need to copy that specific directory
# COPY client/. ./client/  <-- Example if 'client' directory needs to be copied into '/app/client'
COPY . .

# Expose port 3000 (change if your app listens on a different port)
EXPOSE 3000

# Define the command to run your application
# IMPORTANT: Adjust this path if your main entry file is in a subdirectory (e.g., 'node client/server.js')
CMD [ "node", "server.js" ]
