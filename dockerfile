# Use an official Node.js runtime as a parent image
FROM node:18-alpine

# Set the working directory in the container
WORKDIR /app

# Copy package.json and package-lock.json from the 'frontend' directory
# IMPORTANT: Replace 'frontend' with the actual name of the folder containing package.json
COPY frontend/package*.json ./

# Install any dependencies
RUN npm install

# Copy the rest of the application code from the 'frontend' directory
# This copies the contents of your 'frontend' folder into '/app' in the container
COPY frontend/. ./

# Expose port 3000 (adjust if your app listens on a different port)
EXPOSE 3000

# Define the command to run your application
# IMPORTANT: Adjust this path if your main entry file is different or within another sub-folder of 'frontend'
# Example: if your server file is in frontend/src/server.js, it would be 'node src/server.js' here
CMD [ "node", "server.js" ]
